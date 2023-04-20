<?php

namespace App\Exports;

use App\Models\Legislation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class LawsExport implements FromView
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
        $laws = Legislation::with(
            'category',
            'relations',
            'matters',
            'field',
            'institute',
            'user')
            ->whereIn('id', $this->id);

        $laws = isset($this->order) 
            ? $laws->orderBy($this->order, $this->sort)
            : $laws->latest();

        return view('admin.exports.laws', [
            'laws' => $laws->get()
        ]);
    }
}
