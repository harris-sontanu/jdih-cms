<?php

namespace App\Http\Controllers\Jdih\Post;

use App\Http\Controllers\Jdih\Post\PostController;
use App\Http\Traits\VisitorTrait;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Taxonomy;

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
            ->latest()
            ->paginate($this->limit)
            ->withQueryString();

        return view('jdih.post.news.index', compact(
            'posts',
        ))->with('taxonomies', $this->taxonomies);
    }

    public function taxonomy(Taxonomy $taxonomy, Request $request)
    {
        $posts = Post::ofType('news')
            ->where('taxonomy_id', $taxonomy->id)
            ->published()
            ->paginate($this->limit)
            ->withQueryString();

        return view('jdih.post.news.index', compact(
            'posts',
            'taxonomy',
        ))->with('taxonomies', $this->taxonomies);
    }
}
