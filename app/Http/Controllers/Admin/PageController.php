<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TaxonomyType;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Employee;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;
use App\Models\Taxonomy;

class PageController extends AdminController
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Halaman';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.page.index') => 'Halaman',
            'Daftar' => TRUE
        ];

        $pages = Post::ofType(TaxonomyType::PAGE)->with('author', 'cover');

        $onlyTrashed = FALSE;
        if ($tab = $request->tab)
        {
            if ($tab === 'sampah') {
                $pages->onlyTrashed();
                $onlyTrashed = TRUE;
            } else if ($tab === 'terbit') {
                $pages->published();
            } else if ($tab === 'draf') {
                $pages->draft();
            }
        }

        $pages = $pages->search($request->only(['search']))
            ->filter($request)
            ->sorted($request->only(['order', 'sort']))
            ->paginate($request->limit ?: $this->limit)
            ->withQueryString();

        $tabFilters = $this->tabFilters($request);

        $authors = Employee::sorted()->pluck('name', 'id');
        $users = User::sorted()->pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
            'assets/admin/js/vendor/tables/finderSelect/jquery.finderSelect.min.js',
        ];

        return view('admin.page.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'onlyTrashed',
            'pages',
            'authors',
            'users',
            'tabFilters',
            'vendors'
        ));
    }

    private function tabFilters($request)
    {
        return [
            'total'     => Post::ofType(TaxonomyType::PAGE)->with('author', 'cover')
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->count(),
            'draf'      => Post::ofType(TaxonomyType::PAGE)->with('author', 'cover')
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->draft()
                                ->count(),
            'terbit'    => Post::ofType(TaxonomyType::PAGE)->with('author', 'cover')
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->published()
                                ->count(),
            'sampah'    => Post::ofType(TaxonomyType::PAGE)->with('author', 'cover')
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
        $pageHeader = 'Tambah Halaman';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.page.index') => 'Halaman',
            'Detail' => TRUE
        ];
        
        $type = TaxonomyType::PAGE;
        $taxonomies = Taxonomy::type($type)->sorted()->pluck('name', 'id');
        $authors = Employee::sorted()->pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
            'https://cdn.ckeditor.com/ckeditor5/35.3.0/super-build/ckeditor.js',
        ];

        return view('admin.page.create', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'type',
            'taxonomies',
            'authors',
            'vendors',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $validated = $request->validated();
        if ($request->has('publish')) {
            $validated['published_at'] = now();
        }

        $new_pages = $request->user()->posts()->create($validated);

        $this->imageUpload($new_pages, $request);

        return redirect('/admin/page')->with('message', '<strong>Berhasil!</strong> Data Halaman baru telah berhasil disimpan');
    }

    private function imageUpload($page, $request)
    {
        if ($request->hasFile('cover'))
        {
            $file = $request->file('cover');
            $name = $file->hashName();
            $dir  = 'halaman';

            $path = $file->storeAs($dir, $name, 'public');

            // Create thumbnail
            $this->createImageThumbnail($path, $file->getClientOriginalExtension());

            if ($page->cover()->exists()) {
                // Delete current cover
                $this->removeMedia($page->cover->path);
                $page->cover()->delete();
            }

            $new_media = $page->images()->create([
                'name'  => $name,
                'file_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'path'  => $path,
                'caption'   => $request->caption,
                'is_image'  => 1,
                'user_id'   => $request->user()->id,
                'published_at'  => now()->format('Y-m-d H:i:s'),
            ]);

            $page->update([
                'cover_id' => $new_media->id
            ]);
        } else {
            $page->images()->update([
                'caption'   => $request->caption,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $page)
    {
        $pageHeader = 'Halaman';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.page.index') => 'Halaman',
            'Detail' => TRUE
        ];

        $vendors = [
            'assets/admin/js/vendor/media/glightbox.min.js'
        ];

        return view('admin.page.show', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'vendors',
            'page',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $page)
    {
        $pageHeader = 'Ubah Halaman';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.page.index') => 'Halaman',
            'Ubah' => TRUE
        ];

        $type = TaxonomyType::PAGE;
        $taxonomies = Taxonomy::type($type)->sorted()->pluck('name', 'id');
        $authors = Employee::sorted()->pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
            'https://cdn.ckeditor.com/ckeditor5/35.3.0/super-build/ckeditor.js',
            'assets/admin/js/vendor/media/glightbox.min.js',
        ];

        return view('admin.page.edit', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'type',
            'taxonomies',
            'authors',
            'page',
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
    public function update(PageRequest $request, Post $page)
    {
        $validated = $request->validated();
        $validated['published_at'] = empty($page->published_at) ? now() : $page->published_at;
        if ($request->has('draft')) {
            $validated['published_at'] = null;
        }

        $page->update($validated);

        $this->imageUpload($page, $request);

        if ($page->wasChanged()) {
            $typeMessage = 'message';
            $message = '<strong>Berhasil!</strong> Data Halaman telah berhasil diperbarui';
        } else {
            $typeMessage = 'info-message';
            $message = 'Data Halaman tidak ada perubahan';
        }

        return redirect('/admin/page/' . $page->id . '/edit')->with($typeMessage, $message);
    }

    public function trigger(Request $request)
    {
        $ids = $request->items;
        $count = count($ids);

        $message = 'data Halaman telah berhasil diperbarui';
        foreach ($ids as $id)
        {
            $page = Post::withTrashed()->find($id);
            if ($request->action === 'publication')
            {
                if ($request->val === 'draft') {
                    $page->published_at = null;
                } else if ($request->val === 'publish') {
                    $page->published_at = now();
                }
                $page->save();
            }
            else if ($request->action === 'trash')
            {
                $page->delete();
                $message = 'data Halaman telah berhasil dibuang';
            }
            else if ($request->action === 'delete')
            {
                // Remove all page media
                foreach ($page->images as $media) {
                    $this->removeMedia($media->path);
                }

                $page->images()->delete();

                $page->forceDelete();

                $message = 'data Halaman telah berhasil dihapus';
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
    public function destroy(Post $page)
    {
        $action = route('admin.page.restore', $page->id);
        $page->delete();

        return redirect('/admin/page')->with('trash-message', ['<strong>Berhasil!</strong> Data Halaman telah dibuang ke Sampah', $action]);
    }

    public function deleteCover(Post $page)
    {
        $this->removeMedia($page->cover->path);

        $page->images()->delete();
        $page->update(['cover_id' => null]);

        return redirect('/admin/page/' . $page->id . '/edit')->with('message', '<strong>Berhasil!</strong> Data Sampul telah berhasil dihapus');
    }

    public function restore(Post $page)
    {
        $page->restore();

        return redirect()->back()->with('message', 'Data Halaman telah dikembalikan dari Sampah');
    }

    public function forceDestroy(Post $page)
    {
        if ($page->cover) {
            $this->removeMedia($page->cover->path);
        }

        $page->images()->delete();

        $page->forceDelete();

        return redirect('/admin/page?tab=trash')->with('message', '<strong>Berhasil!</strong> Data Halaman telah berhasil dihapus');
    }
}
