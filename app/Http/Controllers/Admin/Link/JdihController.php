<?php

namespace App\Http\Controllers\Admin\Link;

use App\Http\Controllers\Admin\Link\LinkController;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\LinkRequest;

class JdihController extends LinkController
{
    public function __construct()
    {
        $this->authorizeResource(Link::class, 'jdih');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Anggota JDIH';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.link.banner.index') => 'Tautan',
            'Anggota JDIH' => TRUE
        ];

        $jdih = Link::jdih()->with('user', 'image');

        if ($tab = $request->tab)
        {
            if ($tab == 'tayang') {
                $jdih->published();
            } else if ($tab == 'tidak tayang') {
                $jdih->unpublished();
            }
        }

        $limit  = !empty($request->limit) ? $request->limit : $this->limit;

        $jdih = $jdih->search($request->only(['search']))
            ->sorted($request->only(['order', 'sort']))
            ->paginate($limit)
            ->withQueryString();

        $tabFilters = $this->tabFilters($request);

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
            'assets/admin/js/vendor/media/glightbox.min.js',
            'assets/admin/js/vendor/ui/sortable.min.js',
        ];

        if (Gate::denies('isAuthor')) {
            $vendors[] = 'assets/admin/js/vendor/tables/finderSelect/jquery.finderSelect.min.js';
        }

        return view('admin.link.jdih.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'jdih',
            'tabFilters',
            'vendors'
        ));
    }

    private function tabFilters($request)
    {
        return [
            'total'     => Link::jdih()->with('user', 'image')
                                ->sorted($request->only(['order', 'sort']))
                                ->search($request->only(['search']))
                                ->count(),
            'tayang'    => Link::jdih()->with('user', 'image')
                                ->published()
                                ->sorted($request->only(['order', 'sort']))
                                ->search($request->only(['search']))
                                ->count(),
            'tidak tayang' => Link::jdih()->with('user', 'image')
                                ->unpublished()
                                ->sorted($request->only(['order', 'sort']))
                                ->search($request->only(['search']))
                                ->count(),
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LinkRequest $request)
    {
        $validated = $request->validated();
        $validated['published_at'] = ($request->publication) ? now() : null;

        $new_jdih = $request->user()
            ->links()
            ->create($validated);

        $this->imageUpload($request, $new_jdih);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Anggota JDIH baru telah berhasil diunggah');
    }

    private function imageUpload($request, $jdih)
    {
        if ($request->hasFile('image')) {
            $image  = $request->file('image');
            $name   = $image->hashName();
            $dir    = 'tautan/jdih';

            $path   = $image->storeAs($dir, $name, 'public');

            // Create thumbnail
            $this->createImageThumbnail($path, $image->getClientOriginalExtension());

            $new_media = $jdih->images()
                ->create([
                    'name'  => $name,
                    'file_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getClientMimeType(),
                    'path'  => $path,
                    'size'  => $image->getSize(),
                    'user_id'   => $request->user()->id,
                    'published_at'  => now(),
                ]);

            if ($jdih->image_id) {
                $jdih->image->delete();
                $this->removeMedia($jdih->image->path);
            }

            $jdih->update(['image_id' => $new_media->id]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function show(Link $link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function edit(Link $link)
    {
        return view('admin.link.jdih.edit')->with('jdih', $link);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function update(LinkRequest $request, Link $link)
    {
        $validated = $request->validated();
        $validated['published_at'] = ($request->publication) ? now() : null;

        $link->update($validated);

        $this->imageUpload($request, $link);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Anggota JDIH telah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        $this->removeMedia($link->image->path);

        $link->images()->delete();

        $link->delete();

        return redirect('/admin/link/jdih')->with('message', '<strong>Berhasil!</strong> Data JDIH telah berhasil dihapus');
    }
}
