<?php

namespace App\Http\Controllers\Jdih\Post;

use App\Http\Controllers\Jdih\JdihController;
use App\Models\Post;
use App\Models\Media;
use App\Models\Link;

class PostController extends JdihController
{
    protected $limit = 12;

    protected function popularNews()
    {
        return Post::ofType('news')
            ->with('taxonomy', 'author', 'cover')
            ->popular()
            ->published()
            ->take(5)
            ->get();
    }

    protected function latestPhotos()
    {
        return Media::images()
            ->published()
            ->sorted(['order' => 'published_at', 'sort' => 'desc'])
            ->take(9)
            ->get();
    }

    protected function latestVideos()
    {
        return Link::youtubes()
            ->with('user', 'image')
            ->published()
            ->sorted(['order' => 'published_at', 'sort' => 'desc'])
            ->take(3)
            ->get();
    }
}
