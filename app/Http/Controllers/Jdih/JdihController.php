<?php

namespace App\Http\Controllers\Jdih;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Jorenvh\Share\ShareFacade;
use Illuminate\Support\Str;

class JdihController extends Controller
{
    protected static function banners()
    {
        return Link::banners()->whereDisplay('main')->published()->sorted()->get();
    }

    protected function shares()
    {
        $links = ShareFacade::currentPage()
            ->facebook()
            ->twitter()
            ->linkedin()
            ->whatsapp()
            ->telegram()
            ->pinterest()
            ->getRawLinks();

        $colors = ['primary', 'info', 'indigo', 'success', 'teal', 'danger'];

        $i = 0;
        foreach ($links as $key => $value) {
            $shares[] = [
                'title' => Str::title($key),
                'url'   => $value,
                'icon'  => 'ph-' . $key . '-logo',
                'color' => $colors[$i],
            ];
            $i++;
        }

        return $shares;
    }
}
