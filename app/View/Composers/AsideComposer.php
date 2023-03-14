<?php

namespace App\View\Composers;

use App\Models\Type;
use App\Models\Field;
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
        $types = Type::pluck('name', 'slug');

        $fields = Field::sorted()->pluck('name', 'slug');

        $view->with('types', $types)
            ->with('fields', $fields);
    }
}
