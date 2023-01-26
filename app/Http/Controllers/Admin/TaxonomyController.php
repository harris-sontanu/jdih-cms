<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Taxonomy;
use Illuminate\Http\Request;
use App\Http\Requests\TaxonomyRequest;

class TaxonomyController extends AdminController
{
    public function __construct()
    {
        $this->authorizeResource(Taxonomy::class, 'taxonomy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type)
    {
        $pageHeader = ($type === 'news') ? 'Kategori Berita' : 'Kategori ' . $type;
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.'.$type.'.index') => ($type === 'news') ? 'Berita' : $type,
            'Kategori' => TRUE
        ];

        $taxonomies = Taxonomy::type($type)->sorted($request->only(['order', 'sort']));

        // $taxonomies = $taxonomies->search($request->only(['search']));
        $limit = !empty($request->limit) ? $request->limit : $this->limit;
        $taxonomies = $taxonomies->paginate($limit)
                    ->withQueryString();

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
        ];

        return view('admin.taxonomy.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'type',
            'taxonomies',
            'vendors'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaxonomyRequest $request, $type)
    {
        $validated = $request->validated();
        $validated['type'] = $type;
        $new_taxonomy = Taxonomy::create($validated);

        if ($request->has('ajax')) {
            return response()->json(['id' => $new_taxonomy->id, 'type' => $type]);
        } else {
            return redirect('/admin/taxonomy/' . $type)->with('message', '<strong>Berhasil!</strong> Data Kategori baru telah berhasil disimpan');
        }
    }

    public function selectOptions($type, Request $request)
    {
        $taxonomies = Taxonomy::type($type)->sorted()->pluck('name', 'id');
        $selectedId = $request->selectedId;

        return view('admin.taxonomy.select-options', compact('taxonomies', 'selectedId'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Taxonomy  $taxonomy
     * @return \Illuminate\Http\Response
     */
    public function edit(Taxonomy $taxonomy)
    {
        return view('admin.taxonomy.edit')->with('taxonomy', $taxonomy);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Taxonomy  $taxonomy
     * @return \Illuminate\Http\Response
     */
    public function update(TaxonomyRequest $request, Taxonomy $taxonomy)
    {
        $validated = $request->validated();
        $taxonomy->update($validated);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Data Kategori telah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Taxonomy  $taxonomy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Taxonomy $taxonomy)
    {
        $type = $taxonomy->type;
        $taxonomy->delete();

        return redirect('/admin/taxonomy/' . $type)->with('message', '<strong>Berhasil!</strong> Data Kategori telah berhasil dihapus');
    }
}
