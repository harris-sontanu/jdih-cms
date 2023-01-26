<?php

namespace App\Http\Controllers\Admin\Legislation;

use App\Http\Controllers\Admin\Legislation\LegislationController;
use App\Http\Requests\InstituteRequest;
use App\Models\Institute;
use Illuminate\Http\Request;

class InstituteController extends LegislationController
{
    public function __construct()
    {
        $this->authorizeResource(Institute::class, 'institute');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Pemrakarsa';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            'Pemrakarsa' => TRUE
        ];

        $institutes = Institute::sorted($request->only(['order', 'sort']));

        $institutes = $institutes->search($request->only(['search']));
        $limit = !empty($request->limit) ? $request->limit : $this->limit;
        $institutes = $institutes->paginate($limit)
                    ->withQueryString();

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
        ];

        return view('admin.legislation.institute.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'institutes',
            'vendors'
        ));
    }

    public function selectOptions(Request $request)
    {
        $institutes = Institute::sorted()->pluck('name', 'id');
        $selectedId = $request->selectedId;

        return view('admin.legislation.institute.select-options', compact('institutes', 'selectedId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstituteRequest $request)
    {
        $validated = $request->validated();
        $new_institute = Institute::create($validated);

        if ($request->has('ajax')) {             
            return response()->json(['id' => $new_institute->id]);
        } else {
            return redirect('/admin/legislation/institute')->with('message', '<strong>Berhasil!</strong> Data Pemrakarsa baru telah berhasil disimpan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function show(Institute $institute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function edit(Institute $institute)
    {
        return view('admin.legislation.institute.edit', compact('institute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function update(InstituteRequest $request, Institute $institute)
    {
        $validated = $request->validated();
        $institute->update($validated);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Data Pemrakarsa telah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Institute $institute)
    {
        $institute->delete();

        return redirect('/admin/legislation/institute')->with('message', '<strong>Berhasil!</strong> Data Pemrakarsa telah berhasil dihapus');
    }
}
