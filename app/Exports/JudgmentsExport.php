<?php

namespace App\Exports;

use App\Models\Legislation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class JudgmentsExport implements FromView
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
        $judgments = Legislation::with(
            'category',
            'field',
            'user')
            ->whereIn('id', $this->id);
            
        $judgments = isset($this->order)
            ? $judgments->orderBy($this->order, $this->sort)
            : $judgments->latest();

        return view('admin.exports.judgments', [
            'judgments' => $judgments->get()
        ]);
    }
}
