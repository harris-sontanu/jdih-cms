<?php

namespace App\Exports;

use App\Models\Legislation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class MonographsExport implements FromView
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
        $monographs = Legislation::with(
            'category',
            'field',
            'user')
            ->whereIn('id', $this->id);

        if (!empty($this->order))
        {
            $monographs = $monographs->orderBy($this->order, $this->sort);
        }
        else
        {
            $monographs = $monographs->latest();
        }

        return view('admin.exports.monographs', [
            'monographs' => $monographs->get()
        ]);
    }
}
