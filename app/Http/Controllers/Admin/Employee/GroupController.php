<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GroupController extends AdminController
{
    protected $class = [
        'primary',
        'secondary',
        'danger',
        'warning',
        'info',
        'success',
        'default',
        'pink',
        'purple',
        'indigo',
        'teal',
        'yellow',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageHeader = 'Grup Pegawai';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.employee.index') => 'Pegawai',
            'Grup' => TRUE
        ];

        $groups = Group::sorted()->paginate($this->limit);

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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:groups|max:255',
            'desc' => 'nullable',
        ]);

        $validated['class'] = $this->class[rand(0, 11)];

        Group::create($validated);

        return redirect('/admin/employee/group')->with('message', '<strong>Berhasil!</strong> Data Grup Pegawai baru telah berhasil disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('admin.employee.group.edit')->with('group', $group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                Rule::unique('groups')->ignore($group->id),
                'max:255',
            ],
            'desc' => 'nullable',
        ]);
        $group->update($validated);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Data Grup Pegawai telah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return redirect('/admin/employee/group')->with('message', '<strong>Berhasil!</strong> Data Grup Pegawai telah berhasil dihapus');
    }
}
