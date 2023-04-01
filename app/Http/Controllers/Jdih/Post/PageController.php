<?php

namespace App\Http\Controllers\Jdih\Post;

use App\Http\Controllers\Jdih\Post\PostController;
use App\Http\Traits\VisitorTrait;
use App\Models\Post;
use Illuminate\Http\Request;

class PageController extends PostController
{
    use VisitorTrait;

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function profile(Post $post)
    {
        // Record visitor
        $this->recordVisitor(request());

        return view('jdih.post.page')->with('page', $post);
    }

    public function contact()
    {
        $post = Post::whereSlug('kontak')->first();

        return view('jdih.post.contact')->with('page', $post);
    }

}
