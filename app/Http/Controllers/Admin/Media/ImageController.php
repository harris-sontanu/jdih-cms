<?php

namespace App\Http\Controllers\Admin\Media;

use App\Http\Controllers\Admin\Media\MediaController;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ImageController extends MediaController
{
    public function __construct()
    {
        $this->authorizeResource(Media::class, 'image');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Gambar';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.media.image.index') => 'Media',
            'Gambar' => TRUE
        ];

        $images = Media::images()->with('user');

        if ($tab = $request->tab)
        {
            if ($tab == 'terbit') {
                $images->published();
            } else if ($tab == 'draf') {
                $images->draft();
            }
        }

        $limit  = !empty($request->limit) ? $request->limit : $this->limit;

        $images = $images->search($request->only(['search']))
            ->sorted($request->only(['order', 'sort']))
            ->paginate($limit)
            ->withQueryString();

        $tabFilters = $this->tabFilters($request);

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
            'assets/admin/js/vendor/media/glightbox.min.js',
        ];

        if (Gate::denies('isAuthor')) {
            $vendors[] = 'assets/admin/js/vendor/tables/finderSelect/jquery.finderSelect.min.js';
        }

        return view('admin.media.image.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'images',
            'tabFilters',
            'vendors'
        ));
    }

    private function tabFilters($request)
    {
        return [
            'total'     => Media::images()->with('user')->latest()
                                ->search($request->only(['search']))
                                ->count(),
            'terbit'    => Media::images()->with('user')->latest()
                                ->search($request->only(['search']))
                                ->published()
                                ->count(),
            'draf'      => Media::images()->with('user')->latest()
                                ->search($request->only(['search']))
                                ->draft()
                                ->count(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $this->imageUpload($request);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Gambar baru telah berhasil diunggah');
    }

    private function imageUpload($request, $mediaId = null)
    {
        $update = false;
        if ($mediaId) {
            $media = Media::find($mediaId);
            $update = true;
        }

        $hasFile = $request->hasFile('image');
        if ($hasFile) {
            $image  = $request->file('image');
            $name   = $image->hashName();
            $dir    = 'galeri/' . now()->format('Y');

            $path   = $image->storeAs($dir, $name, 'public');

            // Create thumbnail
            $this->createImageThumbnail($path, $image->getClientOriginalExtension());
            $this->createFitImage($path, $image->getClientOriginalExtension());

            $data = [
                'name'  => $name,
                'file_name' => $image->getClientOriginalName(),
                'mime_type' => $image->getClientMimeType(),
                'path'  => $path,
                'caption'   => $request->caption ?? null,
                'is_image'  => 1,
                'published_at'  => ($request->publication) ? now()->format('Y-m-d H:i:s') : null,
            ];
        }

        if ($request->name) {
            $data['name'] = $request->name;
        }

        if ($request->caption) {
            $data['caption'] = $request->caption;
        }

        $data['published_at'] = ($request->publication) ? now()->format('Y-m-d H:i:s') : null;

        if ($update) {
            if ($hasFile) {
                $this->removeMedia($media->path);
            }
            $media->update($data);
        } else {
            $request->user()->media()->create($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        return view('admin.media.image.edit')->with('image', $media);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        $request->validate([
            'image' => 'image|max:2048',
        ]);

        $this->imageUpload($request, $media->id);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Gambar telah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        $image = $media->path;
        $media->delete();

        $this->removeMedia($image);

        return redirect('/admin/media/image')->with('message', '<strong>Berhasil!</strong> Data Gambar telah berhasil dihapus');
    }
}
