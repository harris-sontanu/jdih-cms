<?php

namespace App\Http\Controllers\Jdih\Legislation;

use App\Http\Controllers\Jdih\Legislation\LegislationController;
use App\Models\Category;
use App\Models\Matter;
use App\Models\Institute;
use App\Models\Legislation;
use Illuminate\Support\Facades\Config;
use App\Http\Traits\VisitorTrait;
use Illuminate\Http\Request;

class LawController extends LegislationController
{
    use VisitorTrait;

    private $categories;
    private $matters;
    private $institutes;
    private $orderOptions = [
        'latest-approved'   => 'Terbaru',
        'popular'           => 'Terpopular',
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
            ->pluck('name', 'id');

        $this->matters = Matter::sorted()->pluck('name', 'id');
        $this->institutes = Institute::sorted()->pluck('name', 'id');
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
        ];

        return view('jdih.legislation.law.index', compact(
            'legislations',
            'vendors',
        ))->with('categories', $this->categories)
            ->with('matters', $this->matters)
            ->with('institutes', $this->institutes)
            ->with('orderOptions', $this->orderOptions);
    }

    public function category(Category $category, Request $request)
    {
        $legislations = Legislation::ofType(1)
            ->where('category_id', $category->id)
            ->published()
            ->latestApproved()
            ->paginate($this->limit)
            ->withQueryString();
        
        $categories = Category::ofType(1)
            ->sorted()
            ->pluck('name', 'id');

        $matters = Matter::sorted()->pluck('name', 'id');
        $institutes = Institute::sorted()->pluck('name', 'id');

        $vendors = [
            'assets/jdih/js/vendor/forms/selects/select2.min.js',
        ];

        return view('jdih.legislation.law.index', compact(
            'legislations',
            'category',
            'vendors',
        ))->with('categories', $this->categories)
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

        $adobeKey = Config::get('services.adobe.key');

        $otherLegislations = Legislation::laws()
            ->where('category_id', $legislation->category_id)
            ->whereNot('legislations.id', $legislation->id)
            ->published()
            ->latestApproved()
            ->take(3)
            ->get();

        return view('jembrana.legislation.law.show', compact(
            'legislation',
            'statusRelationships',
            'lawRelationships',
            'documentRelationships',
            'adobeKey',
            'otherLegislations',
        ));
    }
}
