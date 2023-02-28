<?php

namespace App\Http\Controllers\Jdih\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jorenvh\Share\ShareFacade;
use Illuminate\Support\Str;

class PostController extends Controller
{
    protected $limit = 10;

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
