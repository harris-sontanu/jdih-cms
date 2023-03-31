<?php

namespace App\Http\Controllers\Jdih\Legislation;

use App\Http\Controllers\Jdih\Legislation\LegislationController;
use App\Models\Category;
use App\Models\Matter;
use App\Models\Institute;
use App\Models\Legislation;
use App\Models\Post;
use App\Http\Traits\VisitorTrait;
use App\Models\Link;
use Illuminate\Http\Request;

class LawController extends LegislationController
{
    use VisitorTrait;

    private $categories;
    private $matters;
    private $institutes;
    protected $orderOptions = [
        'latest-approved'   => 'Terbaru',
        'popular'           => 'Terpopuler',
        'number-asc'        => 'Nomor kecil ke besar',
        'most-viewed'       => 'Dilihat paling banyak',
        'rare-viewed'       => 'Dilihat paling sedikit',
    ];

    public function __construct(Request $request)
    {
        // Record visitor
        $this->recordVisitor($request);

        $this->categories = Category::ofType(1)
            ->sorted()
            ->pluck('name', 'slug');

        $this->matters = Matter::sorted()->pluck('name', 'slug');
        $this->institutes = Institute::sorted()->pluck('name', 'slug');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $legislations = Legislation::ofType(1)
            ->with(['category', 'category.type'])
            ->filter($request)
            ->published()
            ->sorted($request)
            ->paginate($this->limit)
            ->withQueryString();

        $vendors = [
            'assets/jdih/js/vendor/forms/selects/select2.min.js',
            'assets/jdih/js/vendor/ui/moment/moment.min.js',
            'assets/jdih/js/vendor/pickers/daterangepicker.js',
        ];

        return view('jdih.legislation.law.index', compact(
            'legislations',
            'vendors',
        ))->with('categories', $this->categories)
            ->with('latestMonographs', $this->latestMonographs())
            ->with('banners', $this->banners())
            ->with('matters', $this->matters)
            ->with('institutes', $this->institutes)
            ->with('orderOptions', $this->orderOptions);
    }

    public function category(Category $category, Request $request)
    {
        $legislations = Legislation::ofType(1)
            ->where('category_id', $category->id)
            ->filter($request)
            ->published()
            ->sorted($request)
            ->paginate($this->limit)
            ->withQueryString();

        $vendors = [
            'assets/jdih/js/vendor/forms/selects/select2.min.js',
            'assets/jdih/js/vendor/ui/moment/moment.min.js',
            'assets/jdih/js/vendor/pickers/daterangepicker.js',
        ];

        return view('jdih.legislation.law.index', compact(
            'legislations',
            'category',
            'vendors',
        ))->with('categories', $this->categories)
            ->with('latestMonographs', $this->latestMonographs())
            ->with('banners', $this->banners())
            ->with('matters', $this->matters)
            ->with('institutes', $this->institutes)
            ->with('orderOptions', $this->orderOptions);
    }

    private function orderOptions()
    {
        return [
            'latest-approved'   => 'Terbaru',
            'popular'           => 'Terpopular',
            'number-asc'        => 'Nomor kecil ke besar',
            'most-viewed'       => 'Dilihat paling banyak',
            'rare-viewed'       => 'Dilihat paling sedikit',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Legislation $legislation)
    {
        $legislation->incrementViewCount();

        $statusRelationships = $legislation->relations()->where('type', 'status')->get();
        $lawRelationships = $legislation->relations()->where('type', 'legislation')->get();
        $documentRelationships = $legislation->relations()->where('type', 'document')->get();

        $otherLegislations = Legislation::ofType(1)
            ->where('category_id', $legislation->category_id)
            ->whereNot('id', $legislation->id)
            ->published()
            ->latestApproved()
            ->take(6)
            ->get();

        $latestNews = Post::ofType('news')->with('taxonomy', 'author', 'cover')
            ->published()
            ->latestPublished()
            ->take(5)
            ->get();

        $asideBanners = Link::banners('aside')
            ->published()
            ->sorted()
            ->get();

        $vendors = [
            'assets/jdih/js/vendor/forms/selects/select2.min.js',
            'assets/jdih/js/vendor/share/share.js',
        ];

        return view('jdih.legislation.law.show', compact(
            'legislation',
            'statusRelationships',
            'lawRelationships',
            'documentRelationships',
            'otherLegislations',
            'latestNews',
            'asideBanners',
            'vendors',
        ))->with('adobeKey', $this->adobeKey())
            ->with('banners', $this->banners())
            ->with('shares', $this->shares());
    }
}
