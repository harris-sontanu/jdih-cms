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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::ofType('news')
            ->with('author', 'cover')
            ->published()
            ->latest()
            ->paginate($this->limit)
            ->withQueryString();

        $taxonomies = Taxonomy::type('news')
            ->sorted($request->only(['order', 'sort']))
            ->get();

        $vendors = [
            'assets/jdih/js/vendor/forms/selects/select2.min.js',
        ];

        return view('jdih.post.news.index', compact(
            'posts',
            'taxonomies',
            'vendors',
        ));
    }
}
