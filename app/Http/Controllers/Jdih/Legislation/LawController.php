<?php

namespace App\Http\Controllers\Jdih\Legislation;

use App\Http\Controllers\Jdih\Legislation\LegislationController;
use App\Models\Category;
use App\Models\Legislation;
use Illuminate\Support\Facades\Config;
use App\Http\Traits\VisitorTrait;
use Illuminate\Http\Request;

class LawController extends LegislationController
{
    use VisitorTrait;

    public function __construct(Request $request)
    {
        // Record visitor
        $this->recordVisitor($request);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $legislations = Legislation::ofType(1)
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
        ));
    }

    public function category(Category $category)
    {
        $laws = Legislation::laws()
            ->where('category_id', $category->id)
            ->published()
            ->latestApproved()
            ->paginate($this->limit)
            ->withQueryString();

        return view('jembrana.legislation.law.index', compact(
            'laws',
            'category'
        ));
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
