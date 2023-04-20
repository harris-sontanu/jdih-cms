<?php

namespace App\Exports;

use App\Models\Legislation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class ArticlesExport implements FromView
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
        $articles = Legislation::with(
            'category',
            'field',
            'user')
            ->whereIn('id', $this->id);

        $articles = isset($this->order) 
            ? $articles->orderBy($this->order, $this->sort) 
            : $articles->latest();

        return view('admin.exports.articles', [
            'articles' => $articles->get()
        ]);
    }
}
