<?php

namespace App\Http\Controllers\Jdih;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Category;
use App\Models\Matter;
use App\Models\Institute;
use App\Models\Field;

class HomepageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $types = Type::pluck('name', 'id');
        $categories = Category::ofType(1)
            ->sorted()
            ->pluck('name', 'id');


        $matters = Matter::sorted()->pluck('name', 'id');
        $institutes = Institute::sorted()->pluck('name', 'id');
        $fields = Field::sorted()->pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/forms/selects/select2.min.js',
        ];

        return view('jdih.homepage.index', compact(
            'types',
            'categories',
            'matters',
            'institutes',
            'fields',
            'vendors',
        ));
    }
}
