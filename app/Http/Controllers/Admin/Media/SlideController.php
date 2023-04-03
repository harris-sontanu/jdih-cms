<?php

namespace App\Http\Controllers\Admin\Media;

use App\Http\Controllers\Admin\Media\MediaController;
use App\Http\Requests\SlideRequest;
use App\Models\Slide;
use Illuminate\Http\Request;

class SlideController extends MediaController
{
    public function __construct()
    {
        $this->authorizeResource(Slide::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Slide';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.media.slide.index') => 'Media',
            'Slide' => TRUE
        ];

        $slides = Slide::with('image', 'image.user')
            // ->search($request->only(['search']))
            ->orderBy('sort', 'asc')
            ->paginate($this->limit)
            ->withQueryString();

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
            'assets/admin/js/vendor/media/glightbox.min.js',
            'assets/admin/js/vendor/ui/sortable.min.js',
        ];

        return view('admin.media.slide.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'slides',
            'vendors'
        ));
    }

    public function orderUpdate(Request $request)
    {
        $orders = $request->orders;
        foreach ($orders as $q => $value) {
            Slide::where('id', $value)->update(['sort' => $q+1]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlideRequest $request)
    {
        $validated = $request->validated();
        $newSlide = Slide::create($validated);

        $this->imageUpload($request, $newSlide);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Slide baru telah berhasil diunggah');
    }

    private function imageUpload($request, $slide)
    {
        if (isset($slide->image)) {
            $this->removeMedia($slide->image->path);
            $slide->image()->delete();
        }

        $hasFile = $request->hasFile('image');
        if ($hasFile) {
            $image  = $request->file('image');
            $name   = $image->hashName();
            $dir    = 'slide';

            $path   = $image->storeAs($dir, $name, 'public');

            // Create thumbnail
            $this->createImageThumbnail($path, $image->getClientOriginalExtension());

            $slide->image()->create([
                'name'  => $name,
                'file_name' => $image->getClientOriginalName(),
                'mime_type' => $image->getClientMimeType(),
                'path'  => $path,
                'is_image'  => 0,
                'user_id'   => request()->user()->id,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function edit(Slide $slide)
    {
        return view('admin.media.slide.edit')->with('slide', $slide);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function update(SlideRequest $request, Slide $slide)
    {
        $validated = $request->validated();
        $slide->update($validated);

        $this->imageUpload($request, $slide);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Slide telah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slide $slide)
    {
        $image = $slide->image->path;
        $slide->image()->delete();
        $slide->delete();

        $this->removeMedia($image);

        return redirect('/admin/media/slide')->with('message', '<strong>Berhasil!</strong> Data Slide telah berhasil dihapus');
    }
}
