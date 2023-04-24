<?php

namespace App\Http\Controllers\Admin\Link;

use App\Enums\LinkDisplay;
use App\Http\Controllers\Admin\Link\LinkController;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\LinkRequest;

class BannerController extends LinkController
{
    public function __construct()
    {
        $this->authorizeResource(Link::class, 'banner');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Banner';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.link.banner.index') => 'Tautan',
            'Banner' => TRUE
        ];

        $banners = Link::banners()->with('user', 'image');

        if ($tab = $request->tab)
        {
            if ($tab == 'tayang') {
                $banners->published();
            } else if ($tab == 'tidak tayang') {
                $banners->unpublished();
            }
        }

        $banners = $banners->search($request->only(['search']))
            ->sorted($request->only(['order', 'sort']))
            ->paginate($request->limit ?: $this->limit)
            ->withQueryString();

        $displays = LinkDisplay::cases();

        $tabFilters = $this->tabFilters($request);

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
            'assets/admin/js/vendor/media/glightbox.min.js',
            'assets/admin/js/vendor/ui/sortable.min.js',
        ];

        if (Gate::denies('isAuthor')) {
            $vendors[] = 'assets/admin/js/vendor/tables/finderSelect/jquery.finderSelect.min.js';
        }

        return view('admin.link.banner.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'banners',
            'displays',
            'tabFilters',
            'vendors'
        ));
    }

    private function tabFilters($request)
    {
        return [
            'total'     => Link::banners()->with('user', 'image')
                                ->sorted($request->only(['order', 'sort']))
                                ->search($request->only(['search']))
                                ->count(),
            'tayang'    => Link::banners()->with('user', 'image')
                                ->published()
                                ->sorted($request->only(['order', 'sort']))
                                ->search($request->only(['search']))
                                ->count(),
            'tidak tayang' => Link::banners()->with('user', 'image')
                                ->unpublished()
                                ->sorted($request->only(['order', 'sort']))
                                ->search($request->only(['search']))
                                ->count(),
        ];
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

        $new_banner = $request->user()
            ->links()
            ->create($validated);

        $this->imageUpload($request, $new_banner);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Banner baru telah berhasil diunggah');
    }

    private function imageUpload($request, $banner)
    {
        if ($request->hasFile('image')) {
            $image  = $request->file('image');
            $name   = $image->hashName();
            $dir    = 'tautan/banner';

            $path   = $image->storeAs($dir, $name, 'public');

            // Create thumbnail
            $this->createImageThumbnail($path, $image->getClientOriginalExtension());

            if ($banner->image()->exists()) {
                // Delete current cover
                $this->removeMedia($banner->image->path);
                $banner->image()->delete();
            }

            $banner->image()
                ->create([
                    'name'  => $name,
                    'file_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getClientMimeType(),
                    'path'  => $path,
                    'user_id'   => $request->user()->id,
                    'published_at'  => now(),
                ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function edit(Link $link)
    {
        return view('admin.link.banner.edit')
            ->with('banner', $link)
            ->with('displays', LinkDisplay::cases());
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
        $validated['published_at'] = $request->publication ? now() : null;

        $link->update($validated);

        $this->imageUpload($request, $link);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Banner telah berhasil diperbarui');
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

        return redirect('/admin/link/banner')->with('message', '<strong>Berhasil!</strong> Data Banner telah berhasil dihapus');
    }
}
