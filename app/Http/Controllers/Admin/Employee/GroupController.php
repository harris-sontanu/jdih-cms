<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Taxonomy;
use App\Http\Requests\TaxonomyRequest;
use App\Http\Requests\UpdateGroupRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class GroupController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Grup Pegawai';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.employee.index') => 'Pegawai',
            'Grup' => TRUE
        ];

        $groups = Taxonomy::type('employee')
            ->sorted($request->only(['order', 'sort']))
            ->paginate($request->limit ?: $this->limit)
            ->withQueryString();

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
        ];

        return view('admin.employee.group.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'groups',
            'vendors'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaxonomyRequest $request)
    {
        $validated = $request->validated();
        Taxonomy::create($validated);

        return redirect('/admin/employee/group')->with('message', '<strong>Berhasil!</strong> Data Grup Pegawai baru telah berhasil disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Taxonomy  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Taxonomy $group)
    {
        return view('admin.employee.group.edit')->with('group', $group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Taxonomy  $group
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupRequest $request, Taxonomy $group)
    {
        $validated = $request->validated();
        $group->update($validated);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Data Grup Pegawai telah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Taxonomy  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Taxonomy $group)
    {
        $group->delete();

        return redirect('/admin/employee/group')->with('message', '<strong>Berhasil!</strong> Data Grup Pegawai telah berhasil dihapus');
    }
}
