<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class UsersExport implements FromView
{
    use Exportable;
    
    protected $id;
    protected $order;
    protected $sort;

    function __construct($id, $order = null, $sort = null) {
        $this->id = $id;
        $this->order = $order;
        $this->sort = $sort;
    }

    public function view(): View
    {   
        $users = User::whereIn('id', $this->id);
        $users = isset($this->order)
            ? $users->orderBy($this->order, $this->sort)
            : $users->latest();

        return view('admin.exports.users', [
            'users' => $users->get()
        ]);
    }
}
