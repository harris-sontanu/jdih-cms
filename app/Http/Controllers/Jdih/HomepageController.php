<?php

namespace App\Http\Controllers\Jdih;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Category;
use App\Models\Matter;
use App\Models\Institute;
use App\Models\Field;
use App\Models\Legislation;
use Illuminate\Support\Facades\Config;

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

        $totalLaws        = Legislation::ofType(1)->published()->count();
        $totalMonographs  = Legislation::ofType(2)->published()->count();
        $totalArticles 	  = Legislation::ofType(3)->published()->count();
        $totalJudgments	  = Legislation::ofType(4)->published()->count();

        $popularLaw = Legislation::ofType(1)->popular(120)->first();
        $popularLawDoc = $popularLaw->documents()
            ->ofType('master')
            ->first();
        $adobeKey = Config::get('services.adobe.key');

        $latestLaws = Legislation::ofType(1)
            ->published()
            ->latestApproved()
            ->take(6)
            ->get();

        $styles = [
            'https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap',
        ];

        $vendors = [
            'assets/jdih/js/vendor/forms/selects/select2.min.js',
        ];

        return view('jdih.homepage.index', compact(
            'types',
            'categories',
            'matters',
            'institutes',
            'fields',
            'totalLaws',
            'totalMonographs',
            'totalArticles',
            'totalJudgments',
            'popularLaw',
            'popularLawDoc',
            'adobeKey',
            'latestLaws',
            'styles',
            'vendors',
        ));
    }
}
