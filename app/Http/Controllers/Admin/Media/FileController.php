<?php

namespace App\Http\Controllers\Admin\Media;

use App\Http\Controllers\Admin\Media\MediaController;
use App\Models\Media;
use Illuminate\Http\Request;

class FileController extends MediaController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Berkas';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.media.image.index') => 'Media',
            'Berkas' => TRUE
        ];

        $files = Media::files()->with('user');

        if ($tab = $request->tab)
        {
            if ($tab == 'tayang') {
                $files->published();
            } else if ($tab == 'tidak tayang') {
                $files->unpublished();
            }
        }

        $limit  = !empty($request->limit) ? $request->limit : $this->limit;

        $files = $files->search($request->only(['search']))
            ->sorted($request->only(['order', 'sort']))
            ->paginate($limit)
            ->withQueryString();

        $tabFilters = $this->tabFilters($request);

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
            'assets/admin/js/vendor/tables/finderSelect/jquery.finderSelect.min.js',
        ];

        return view('admin.media.file.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'files',
            'tabFilters',
            'vendors'
        ));
    }

    private function tabFilters($request)
    {
        return [
            'total'     => Media::files()->with('user')->latest()
                                ->search($request->only(['search']))
                                ->count(),
            'tayang'   => Media::files()->with('user')->latest()
                                ->search($request->only(['search']))
                                ->published()
                                ->count(),
            'tidak tayang' => Media::files()->with('user')->latest()
                                ->search($request->only(['search']))
                                ->unpublished()
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
            'file' => 'required|file|max:2048',
        ]);

        $this->fileUpload($request);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Berkas baru telah berhasil diunggah');
    }

    private function fileUpload($request, $mediaId = null)
    {
        $update = false;
        if ($mediaId) {
            $media = Media::find($mediaId);
            $update = true;
        }

        $hasFile = $request->hasFile('file');
        if ($hasFile) {
            $file   = $request->file('file');
            $name   = $file->hashName();
            $dir    = 'media/' . now()->format('Y');

            $path   = $file->storeAs($dir, $name, 'public');

            $data = [
                'name'  => $name,
                'file_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'path'  => $path,
                'size'  => $file->getSize(),
                'published_at'  => ($request->publication) ? now()->format('Y-m-d H:i:s') : null,
            ];
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
        return view('admin.media.file.edit')->with('file', $media);
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
            'file' => 'file|max:2048',
        ]);

        $this->fileUpload($request, $media->id);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Berkas telah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        $file = $media->path;
        $media->delete();

        $this->removeMedia($file);

        return redirect('/admin/media/file')->with('message', '<strong>Berhasil!</strong> Data Berkas telah berhasil dihapus');
    }
}
