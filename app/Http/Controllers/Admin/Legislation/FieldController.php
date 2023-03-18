<?php

namespace App\Http\Controllers\Admin\Legislation;

use App\Models\Field;
use Illuminate\Http\Request;
use App\Http\Requests\FieldRequest;

class FieldController extends LegislationController
{
    public function __construct()
    {
        $this->authorizeResource(Field::class, 'field');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Bidang Hukum';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            'Bidang Hukum' => TRUE
        ];

        $fields = Field::with('legislations')
            ->search($request->only(['search']))
            ->sorted($request->only(['order', 'sort']))
            ->paginate($request->limit ?: $this->limit)
            ->withQueryString();

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
        ];

        return view('admin.legislation.field.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'fields',
            'vendors'
        ));
    }

    public function selectOptions(Request $request)
    {
        $fields = Field::sorted()->pluck('name', 'id');
        $selectedId = $request->selectedId;

        return view('admin.legislation.field.select-options', compact('fields', 'selectedId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FieldRequest $request)
    {
        $validated = $request->validated();
        $new_field = Field::create($validated);

        if ($request->has('ajax')) {
            return response()->json(['id' => $new_field->id]);
        } else {
            return redirect('/admin/legislation/field')->with('message', '<strong>Berhasil!</strong> Data Bidang Hukum baru telah berhasil disimpan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        return view('admin.legislation.field.edit', compact('field'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(FieldRequest $request, Field $field)
    {
        $validated = $request->validated();
        $field->update($validated);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Data Bidang Hukum telah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $field)
    {
        $field->delete();

        return redirect('/admin/legislation/field')->with('message', '<strong>Berhasil!</strong> Data Bidang Hukum telah berhasil dihapus');
    }
}
