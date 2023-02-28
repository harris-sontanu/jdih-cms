<?php

namespace App\View\Composers;

use App\Models\Legislation;
use App\Models\Type;
use App\Models\Field;
use App\Models\Post;
use App\Models\Link;
use Illuminate\View\View;

class AsideComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $types = Type::pluck('name', 'id');

        $fields = Field::sorted()->pluck('name', 'id');

        $popularNews = Post::ofType('news')->with('taxonomy', 'author', 'cover')
            ->popular()
            ->published()
            ->take(5)
            ->get();

        $popularMonographs = Legislation::ofType(2)
            ->published()
            ->latest()
            ->take(3)
            ->get();

        $view->with('types', $types)
            ->with('fields', $fields)
            ->with('popularNews', $popularNews)
            ->with('popularMonographs', $popularMonographs);
    }
}
