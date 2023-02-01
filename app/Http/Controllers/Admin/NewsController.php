<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Post;
use App\Models\Taxonomy;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\NewsRequest;

class NewsController extends AdminController
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'news');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Berita';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.news.index') => 'Berita',
            'Daftar' => TRUE
        ];

        $news = Post::ofType('news')->with('author', 'cover');

        $onlyTrashed = FALSE;
        if ($tab = $request->tab)
        {
            if ($tab === 'sampah') {
                $news->onlyTrashed();
                $onlyTrashed = TRUE;
            } else if ($tab === 'terbit') {
                $news->published();
            } else if ($tab === 'terjadwal') {
                $news->scheduled();
            } else if ($tab === 'draf') {
                $news->draft();
            }
        }
        $limit = !empty($request->limit) ? $request->limit : $this->limit;

        $news = $news->search($request->only(['search']))
            ->filter($request)
            ->sorted($request->only(['order', 'sort']))
            ->paginate($limit)
            ->withQueryString();

        $tabFilters = $this->tabFilters($request);

        $taxonomies = Taxonomy::type('news')->sorted()->pluck('name', 'id');
        $users = User::sorted()->pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
            'assets/admin/js/vendor/tables/finderSelect/jquery.finderSelect.min.js',
        ];

        return view('admin.news.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'onlyTrashed',
            'news',
            'taxonomies',
            'users',
            'tabFilters',
            'vendors'
        ));
    }

    private function tabFilters($request)
    {
        return [
            'total'     => Post::ofType('news')->with('author', 'cover')
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->count(),
            'draf'      => Post::ofType('news')->with('author', 'cover')
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->draft()
                                ->count(),
            'terbit'    => Post::ofType('news')->with('author', 'cover')
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->published()
                                ->count(),
            'terjadwal' => Post::ofType('news')->with('author', 'cover')
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->scheduled()
                                ->count(),
            'sampah'    => Post::ofType('news')->with('author', 'cover')
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->onlyTrashed()
                                ->count()
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Tambah Berita';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.news.index') => 'Berita',
            'Detail' => TRUE
        ];

        $type = 'news';
        $taxonomies = Taxonomy::type($type)->sorted()->pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
            'assets/admin/js/vendor/uploaders/fileinput/fileinput.min.js',
            'https://cdn.ckeditor.com/ckeditor5/35.3.0/super-build/ckeditor.js',
        ];

        return view('admin.news.create', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'type',
            'taxonomies',
            'vendors',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        $validated = $request->validated();
        if ($request->has('draft')) {
            $validated['published_at'] = null;
        }

        $new_news = $request->user()->posts()->create($validated);

        $this->imageUpload($new_news, $request);

        return redirect('/admin/news')->with('message', '<strong>Berhasil!</strong> Data Berita baru telah berhasil disimpan');
    }

    private function imageUpload($news, $request)
    {
        if ($request->hasFile('cover'))
        {
            $file = $request->file('cover');
            $name = $file->hashName();
            $dir  = 'berita/' . now()->format('Y');

            $path = $file->storeAs($dir, $name, 'public');

            // Create thumbnail
            $this->createImageThumbnail($path, $file->getClientOriginalExtension());

            $new_media = $news->images()->create([
                'name'  => $name,
                'file_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'path'  => $path,
                'caption'   => $request->caption,
                'is_image'  => 1,
                'size'  => $file->getSize(),
                'user_id'   => $request->user()->id,
                'published_at'  => now()->format('Y-m-d H:i:s'),
            ]);

            // Check if it already has cover
            if ($news->cover_id) {

                // Delete old cover
                $this->removeMedia($news->cover->path);

                $news->cover()->delete();
            }

            $news->update([
                'cover_id' => $new_media->id
            ]);
        }

        if ($request->hasFile('photos'))
        {
            foreach ($request->file('photos') as $photo) {

                $name = $photo->hashName();
                $dir  = 'berita/' . now()->format('Y');

                $path = $photo->storeAs($dir, $name, 'public');

                // Create thumbnail
                $this->createImageThumbnail($path, $photo->getClientOriginalExtension());

                $new_media = $news->images()->create([
                    'name'  => $name,
                    'file_name' => $photo->getClientOriginalName(),
                    'mime_type' => $photo->getClientMimeType(),
                    'path'  => $path,
                    'is_image'  => 1,
                    'size'  => $photo->getSize(),
                    'published_at'  => now()->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $news)
    {
        $pageHeader = 'Berita';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.news.index') => 'Berita',
            'Detail' => TRUE
        ];

        $vendors = [
            'assets/admin/js/vendor/media/glightbox.min.js'
        ];

        return view('admin.news.show', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'vendors',
            'news',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $news)
    {
        $pageHeader = 'Ubah Berita';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.news.index') => 'Berita',
            'Ubah' => TRUE
        ];

        $type = 'news';
        $taxonomies = Taxonomy::type($type)->sorted()->pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
            'assets/admin/js/vendor/uploaders/fileinput/fileinput.min.js',
            'https://cdn.ckeditor.com/ckeditor5/35.3.0/super-build/ckeditor.js',
            'assets/admin/js/vendor/media/glightbox.min.js',
        ];

        return view('admin.news.edit', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'type',
            'taxonomies',
            'news',
            'vendors',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, Post $news)
    {
        $validated = $request->validated();

        if ($request->has('draft')) {
            $validated['published_at'] = null;
        }

        $news->update($validated);

        $this->imageUpload($news, $request);

        if ($news->wasChanged()) {
            $typeMessage = 'message';
            $message = '<strong>Berhasil!</strong> Data Berita telah berhasil diperbarui';
        } else {
            $typeMessage = 'info-message';
            $message = 'Data Berita tidak ada perubahan';
        }

        return redirect('/admin/news/' . $news->id . '/edit')->with($typeMessage, $message);
    }

    public function trigger(Request $request)
    {
        $ids = $request->items;
        $count = count($ids);

        $message = 'data Berita telah berhasil diperbarui';
        foreach ($ids as $id)
        {
            $news = Post::withTrashed()->find($id);
            if ($request->action === 'taxonomy')
            {
                $news->taxonomy_id = $request->val;
                $news->save();
            }
            else if ($request->action === 'trash')
            {
                $news->delete();
                $message = 'data Berita telah berhasil dibuang';
            }
            else if ($request->action === 'delete')
            {
                // Remove all news media
                foreach ($news->images as $media) {
                    $this->removeMedia($media->path);
                }

                $news->images()->delete();

                $news->forceDelete();

                $message = 'data Berita telah berhasil dihapus';
            }
        }

        $request->session()->flash('message', '<span class="badge rounded-pill bg-success">' . $count . '</span> ' . $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $news)
    {
        $action = route('admin.news.restore', $news->id);
        $news->delete();

        return redirect('/admin/news')->with('trash-message', ['<strong>Berhasil!</strong> Data Berita telah dibuang ke Sampah', $action]);
    }

    public function restore(Post $news)
    {
        $news->restore();

        return redirect()->back()->with('message', 'Data Berita telah dikembalikan dari Sampah');
    }

    public function forceDestroy(Post $news)
    {
        // Remove all news media
        foreach ($news->images as $media) {
            $this->removeMedia($media->path);
        }

        $news->images()->delete();

        $news->forceDelete();

        return redirect('/admin/news?tab=trash')->with('message', '<strong>Berhasil!</strong> Data Berita telah berhasil dihapus');
    }
}
