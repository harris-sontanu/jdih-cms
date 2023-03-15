<?php

namespace App\Http\Controllers\Admin\Media;

use App\Http\Controllers\Admin\Media\MediaController;
use App\Models\Slide;
use Illuminate\Http\Request;

class SlideController extends MediaController
{
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

        $slides = Slide::with('image')
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
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048|dimensions:min_width=1920,min_height=480',
        ]);

        $newSlide = Slide::create([
            'header'    => $request->header,
            'subheader' => $request->subheader,
            'desc'      => $request->desc,
            'position'  => $request->position,
        ]);

        $this->imageUpload($request, $newSlide);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Slide baru telah berhasil diunggah');
    }

    private function imageUpload($request, $slide)
    {
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
