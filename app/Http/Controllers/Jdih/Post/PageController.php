<?php

namespace App\Http\Controllers\Jdih\Post;

use App\Http\Controllers\Jdih\Post\PostController;
use App\Models\Post;
use Illuminate\Http\Request;

class PageController extends PostController
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('jdih.post.page')->with('page', $post);
    }

}
