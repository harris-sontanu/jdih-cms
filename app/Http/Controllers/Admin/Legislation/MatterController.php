<?php

namespace App\Http\Controllers\Admin\Legislation;

use App\Http\Controllers\Admin\Legislation\LegislationController;
use App\Models\Matter;
use Illuminate\Http\Request;
use App\Http\Requests\MatterRequest;

class MatterController extends LegislationController
{
    public function __construct()
    {
        $this->authorizeResource(Matter::class, 'matter');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Urusan Pemerintahan';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            'Urusan Pemerintahan' => TRUE
        ];

        $matters = Matter::with('legislations')
            ->search($request->only(['search']))
            ->sorted($request->only(['order', 'sort']))
            ->paginate($request->limit ?: $this->limit)
            ->withQueryString();

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
        ];

        return view('admin.legislation.matter.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'matters',
            'vendors'
        ));
    }

    public function selectOptions(Request $request)
    {
        $matters = Matter::pluck('name', 'id');
        $selectedId = $request->selectedId;

        return view('admin.legislation.matter.select-options', compact('matters', 'selectedId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MatterRequest $request)
    {
        $validated = $request->validated();
        $new_matter = Matter::create($validated);

        if ($request->has('ajax')) {
            return response()->json(['id' => $new_matter->id]);
        } else {
            return redirect('/admin/legislation/matter')->with('message', '<strong>Berhasil!</strong> Data Urusan Pemerintahan baru telah berhasil disimpan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matter  $matter
     * @return \Illuminate\Http\Response
     */
    public function edit(Matter $matter)
    {
        return view('admin.legislation.matter.edit', compact('matter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Matter  $matter
     * @return \Illuminate\Http\Response
     */
    public function update(MatterRequest $request, Matter $matter)
    {
        $validated = $request->validated();
        $matter->update($validated);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Data Urusan Pemerintahan telah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Matter  $matter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matter $matter)
    {
        $matter->delete();

        return redirect('/admin/legislation/matter')->with('message', '<strong>Berhasil!</strong> Data Urusan Pemerintahan telah berhasil dihapus');
    }
}
