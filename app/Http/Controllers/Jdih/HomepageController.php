<?php

namespace App\Http\Controllers\Jdih;

use App\Http\Controllers\Jdih\JdihController;
use App\Http\Traits\VisitorTrait;
use App\Models\Type;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Matter;
use App\Models\Institute;
use App\Models\Field;
use App\Models\Legislation;
use App\Models\Link;
use App\Models\Post;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;

use function PHPUnit\Framework\isNull;

class HomepageController extends JdihController
{
    use VisitorTrait;

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

        $popularLaw = Legislation::ofType(1)->popular()->first();
        $popularLawDoc = $popularLaw->documents()
            ->ofType('master')
            ->first();

        $adobeKey = Config::get('services.adobe.key');

        $latestLaws = Legislation::ofType(1)
            ->published()
            ->latestApproved()
            ->take(6)
            ->get();

        $monograph = Legislation::ofType(2)
            ->published()
            ->latest()
            ->first();

        $cover = $monograph->documents()
            ->ofType('cover')
            ->first();

        $latestNews = Post::ofType('news')->with('taxonomy', 'author', 'cover')
            ->published()
            ->latestPublished()
            ->limit(6)
            ->get();

        $members = Employee::ofGroup('pengelola-jdih')
            ->sorted()
            ->get();

        $slides = Slide::orderBy('sort', 'asc')
            ->get();

        $popupBanner = $this->popupBanner();

        // Record visitor
        $this->recordVisitor($request);

        $styles = [
            'https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap',
            'https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css',
        ];

        $vendors = [
            'assets/jdih/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/visualization/echarts/echarts.min.js',
			'assets/admin/js/vendor/visualization/d3/d3.min.js',
			'assets/admin/js/vendor/visualization/d3/d3_tooltip.js',
            'https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js',
            'https://unpkg.com/counterup2@2.0.2/dist/index.js',
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
            'monograph',
            'cover',
            'latestNews',
            'members',
            'slides',
            'popupBanner',
            'styles',
            'vendors',
        ))->with('banners', $this->banners());
    }

    private function popupBanner()
    {
        $popupBanner = Link::banners()
            ->whereDisplay('popup')
            ->first();

        if (isset($popupBanner)) {
            $cookie = Cookie::get('popup-banner');
            if (is_null($cookie)) {
                Cookie::queue('popup-banner', $popupBanner->title, 120);
            } else {
                $popupBanner = null;
            }
        }

        return $popupBanner;
    }
}
