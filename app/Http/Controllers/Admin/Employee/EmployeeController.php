<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Employee;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;

class EmployeeController extends AdminController
{
    public function __construct()
    {
        $this->authorizeResource(Employee::class, 'employee');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Pegawai';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.employee.index') => 'Pegawai',
            'Daftar' => TRUE
        ];

        $employees = Employee::with('groups')
            ->search($request->only(['search']))
            ->filter($request)
            ->sorted($request->only(['order', 'sort']))
            ->paginate((!empty($request->limit)) ? $request->limit : $this->limit)
            ->withQueryString();

        $groups = Group::pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/sortable.min.js',
            'assets/admin/js/vendor/tables/finderSelect/jquery.finderSelect.min.js',
        ];

        return view('admin.employee.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'employees',
            'groups',
            'vendors'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Tambah Pegawai';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.employee.index') => 'Pegawai',
            'Tambah' => TRUE
        ];

        $groups = Group::pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/forms/selects/select2.min.js',
        ];

        return view('admin.employee.create', compact(
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
    public function store(EmployeeRequest $request)
    {
        $validated = $this->handleRequest($request);

        $new_employee = Employee::create($validated);

        $new_employee->groups()->attach($request->groups);

        return redirect('/admin/employee')->with('message', '<strong>Berhasil!</strong> Data Pegawai baru telah berhasil disimpan');
    }

    private function handleRequest($request)
    {
        $data  = $request->validated();
        $input = $request->all();

        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $path  = $image->store('staf', 'public');

            // Create fit image
            $extension = $image->getClientOriginalExtension();
            $this->createFitImage($path, $extension);

            $data['picture'] = $path;
        }

        return array_merge($input, $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('admin.employee.show')->with('employee', $employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $pageHeader = 'Ubah Pegawai';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.employee.index') => 'Pegawai',
            'Ubah' => TRUE
        ];

        $groups = Group::pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/forms/selects/select2.min.js',
        ];

        return view('admin.employee.edit', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'groups',
            'employee',
            'vendors'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $oldPicture = $employee->picture;
        $validated  = $this->handleRequest($request);

        $employee->update($validated);

        $employee->groups()->sync($request->groups);

        if ($oldPicture !== $employee->picture) {
            $this->removeMedia($oldPicture);
        }

        return redirect('/admin/employee')->with('message', '<strong>Berhasil!</strong> Perubahan data Pegawai telah berhasil disimpan');
    }

    public function orderUpdate(Request $request)
    {
        $orders = $request->orders;
        foreach ($orders as $q => $value) {
            Employee::where('id', $value)->update(['sort' => $q+1]);
        }
    }

    public function trigger(Request $request)
    {
        $ids = $request->items;
        $count = count($ids);

        $message = 'data Pegawai telah berhasil diperbarui';
        foreach ($ids as $id)
        {
            $employee = Employee::find($id);
            if ($request->action === 'group')
            {
                $employee->groups()->toggle([$request->val]);
            }
            else if ($request->action === 'delete')
            {
                $picture = $employee->picture;
                $employee->delete();

                $this->removeMedia($picture);

                $message = 'data Berita telah berhasil dihapus';
            }
        }

        $request->session()->flash('message', '<span class="badge rounded-pill bg-success">' . $count . '</span> ' . $message);
    }
    

    public function deleteAvatar(Request $request, Employee $employee)
    {
        $this->removeMedia($employee->picture);
        $employee->update(['picture' => null]);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Data Foto telah berhasil dihapus');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $picture = $employee->picture;
        $employee->delete();

        $this->removeMedia($picture);

        return redirect('/admin/employee')->with('message', '<strong>Berhasil!</strong> Data Pegawai telah berhasil dihapus');
    }
}
