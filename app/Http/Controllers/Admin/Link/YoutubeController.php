<?php

namespace App\Http\Controllers\Admin\Link;

use App\Http\Controllers\Admin\Link\LinkController;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\LinkRequest;

class YoutubeController extends LinkController
{
    public function __construct()
    {
        $this->authorizeResource(Link::class, 'youtube');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'YouTube';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.link.youtube.index') => 'Tautan',
            'YouTube' => TRUE
        ];

        $youtubes = Link::youtubes()->with('user', 'image');

        if ($tab = $request->tab)
        {
            if ($tab == 'tayang') {
                $youtubes->published();
            } else if ($tab == 'tidak tayang') {
                $youtubes->unpublished();
            }
        }

        $limit  = !empty($request->limit) ? $request->limit : $this->limit;

        $youtubes = $youtubes->search($request->only(['search']))
            ->latest()
            ->paginate($limit)
            ->withQueryString();

        $tabFilters = $this->tabFilters($request);

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
        ];

        if (Gate::denies('isAuthor')) {
            $vendors[] = 'assets/admin/js/vendor/tables/finderSelect/jquery.finderSelect.min.js';
        }

        return view('admin.link.youtube.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'youtubes',
            'tabFilters',
            'vendors'
        ));
    }

    private function tabFilters($request)
    {
        return [
            'total'     => Link::youtubes()->with('user', 'image')
                                ->sorted($request->only(['order', 'sort']))
                                ->search($request->only(['search']))
                                ->count(),
            'tayang'    => Link::youtubes()->with('user', 'image')
                                ->published()
                                ->sorted($request->only(['order', 'sort']))
                                ->search($request->only(['search']))
                                ->count(),
            'tidak tayang' => Link::youtubes()->with('user', 'image')
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

        $request->user()->links()->create($validated);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Tautan YouTube baru telah berhasil diunggah');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function edit(Link $link)
    {
        return view('admin.link.youtube.edit')->with('youtube', $link);
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

        $request->session()->flash('message', '<strong>Berhasil!</strong> Tautan YouTube telah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        $link->delete();

        return redirect('/admin/link/youtube')->with('message', '<strong>Berhasil!</strong> Data Tautan YouTube telah berhasil dihapus');
    }
}
