<?php

namespace App\Http\Controllers\Jdih\Post;

use App\Http\Controllers\Jdih\Post\PostController;
use App\Http\Traits\VisitorTrait;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Taxonomy;
use App\Models\Link;
use App\Models\Media;

class NewsController extends PostController
{
    use VisitorTrait;
    protected $taxonomies;

    public function __construct(Request $request)
    {
        // Record visitor
        $this->recordVisitor($request);

        $this->taxonomies = Taxonomy::type('news')
            ->sorted($request->only(['order', 'sort']))
            ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::ofType('news')
            ->with('author', 'cover')
            ->filter($request)
            ->published()
            ->latestPublished()
            ->paginate($this->limit)
            ->withQueryString();

        $vendors = [
            'assets/admin/js/vendor/media/glightbox.min.js',
        ];

        return view('jdih.post.news.index', compact(
            'posts',
            'vendors',
        ))->with('taxonomies', $this->taxonomies)
            ->with('popularNews', $this->popularNews())
            ->with('youtubes', $this->latestVideos())
            ->with('photos', $this->latestPhotos())
            ->with('banners', $this->banners());
    }

    public function taxonomy(Taxonomy $taxonomy, Request $request)
    {
        $posts = Post::ofType('news')
            ->where('taxonomy_id', $taxonomy->id)
            ->published()
            ->paginate($this->limit)
            ->withQueryString();

        $vendors = [
            'assets/admin/js/vendor/media/glightbox.min.js',
        ];

        return view('jdih.post.news.index', compact(
            'posts',
            'taxonomy',
            'vendors',
        ))->with('taxonomies', $this->taxonomies)
            ->with('popularNews', $this->popularNews())
            ->with('youtubes', $this->latestVideos())
            ->with('photos', $this->latestPhotos())
            ->with('banners', $this->banners());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function show(Taxonomy $taxonomy, Post $post)
    {
        $post->incrementViewCount();

        $otherNews = Post::ofType('news')
            ->where('taxonomy_id', $post->taxonomy_id)
            ->whereNot('id', $post->id)
            ->published()
            ->latestPublished()
            ->take(3)
            ->get();

        $youtubes = Link::youtubes()->with('user', 'image')->take(3)->get();

        $photos = Media::images()->published()->take(9)->get();

        $vendors = [
            'assets/jdih/js/vendor/share/share.js',
            'assets/admin/js/vendor/media/glightbox.min.js',
        ];

        return view('jdih.post.news.show', compact(
            'otherNews',
            'youtubes',
            'photos',
            'vendors',
        ))->with('news', $post)
            ->with('shares', $this->shares())
            ->with('popularNews', $this->popularNews())
            ->with('youtubes', $this->latestVideos())
            ->with('photos', $this->latestPhotos())
            ->with('banners', $this->banners());
    }
}
