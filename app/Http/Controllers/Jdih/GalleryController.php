<?php

namespace App\Http\Controllers\Jdih;

use App\Http\Controllers\Jdih\JdihController;
use App\Http\Traits\VisitorTrait;
use Illuminate\Http\Request;
use App\Models\Media;

class GalleryController extends JdihController
{
    use VisitorTrait;

    public function photo(Request $request)
    {
        $photos = Media::images()
            ->published()
            ->sorted()
            ->paginate(12)
            ->withQueryString();

        $vendors = [
            'assets/admin/js/vendor/media/glightbox.min.js',
        ];

        return view('jdih.gallery.photo', compact(
            'photos',
            'vendors',
        ));
    }
}
