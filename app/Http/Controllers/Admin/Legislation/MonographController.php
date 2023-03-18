<?php

namespace App\Http\Controllers\Admin\Legislation;

use App\Http\Controllers\Admin\Legislation\LegislationController;
use App\Models\Legislation;
use App\Models\Category;
use App\Models\Field;
use App\Models\User;
use App\Http\Requests\MonographRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonographsExport;

class MonographController extends LegislationController
{
    public function __construct()
    {
        $this->authorizeResource(Legislation::class, 'monograph');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Monografi Hukum';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            'Monografi Hukum' => TRUE
        ];

        $monographs = Legislation::ofType(2);

        $onlyTrashed = FALSE;
        if ($tab = $request->tab)
        {
            if ($tab === 'sampah') {
                $monographs->onlyTrashed();
                $onlyTrashed = TRUE;
            } else if ($tab === 'terbit') {
                $monographs->published();
            } else if ($tab === 'terjadwal') {
                $monographs->scheduled();
            } else if ($tab === 'draf') {
                $monographs->draft();
            }
        }

        $monographs = $monographs->search($request->only(['search']))
            ->filter($request)
            ->sorted($request->only(['order', 'sort']))
            ->paginate($request->limit ?: $this->limit)
            ->withQueryString();

        $tabFilters = $this->tabFilters($request);

        $categories = Category::ofType(2)->pluck('name', 'id');
        $fields = Field::sorted()->pluck('name', 'id');
        $users = User::sorted()->pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
        ];

        if (Gate::denies('isAuthor')) {
            $vendors[] = 'assets/admin/js/vendor/tables/finderSelect/jquery.finderSelect.min.js';
        }

        return view('admin.legislation.monograph.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'onlyTrashed',
            'monographs',
            'tabFilters',
            'categories',
            'fields',
            'users',
            'vendors'
        ));
    }

    private function tabFilters($request)
    {
        return [
            'total'     => Legislation::ofType(2)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->count(),
            'draf'      => Legislation::ofType(2)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->draft()
                                ->count(),
            'terbit'    => Legislation::ofType(2)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->published()
                                ->count(),
            'terjadwal' => Legislation::ofType(2)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->scheduled()
                                ->count(),
            'sampah'    => Legislation::ofType(2)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->onlyTrashed()
                                ->count()
        ];
    }

    public function export($format, Request $request)
    {
        $array_id = explode(',', $request->id);

        if ($format === 'excel')
        {
            return Excel::download(new MonographsExport($array_id, $request->order, $request->sort), 'monografi.xlsx');
        }
        else if ($format === 'pdf')
        {
            return (new MonographsExport($array_id, $request->order, $request->sort))
                ->download('monografi.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Tambah Monografi Hukum';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('admin.legislation.monograph.index') => 'Monografi Hukum',
            'Tambah' => TRUE
        ];

        $categories = Category::ofType(2)->pluck('name', 'id');
        $fields = Field::sorted()->pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
        ];

        return view('admin.legislation.monograph.create', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'categories',
            'fields',
            'vendors',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MonographRequest $request)
    {
        $validated = $request->validated();

        $message = 'menambahkan monografi';
        if ($request->has('draft')) {
            $validated['published_at'] = null;
            $message .= ' sebagai Draf';
        }

        $new_legislation = $request->user()->legislations()->create($validated);

        $this->documentUpload($new_legislation, $request);

        $new_legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => $message,
        ]);

        return redirect('/admin/legislation/monograph')->with('message', '<strong>Berhasil!</strong> Data Monografi baru telah berhasil disimpan');
    }

    private function documentUpload($legislation, $request)
    {
        if ($request->hasFile('cover'))
        {
            $this->storeDocument($request->file('cover'), $legislation, 'cover');

            $legislation->logs()->create([
                'user_id'   => $request->user()->id,
                'message'   => 'mengunggah dokumen Sampul',
            ]);
        }

        if ($request->hasFile('attachment'))
        {
            $this->storeDocument($request->file('attachment'), $legislation, 'attachment');

            $legislation->logs()->create([
                'user_id'   => $request->user()->id,
                'message'   => 'mengunggah dokumen Lampiran',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function show(Legislation $legislation)
    {
        $pageHeader = $legislation->title;
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('admin.legislation.monograph.index') => 'Monografi Hukum',
            'Detail' => TRUE
        ];

        $cover = $legislation->documents()
            ->ofType('cover')
            ->first();

        $attachment = $legislation->documents()
            ->ofType('attachment')
            ->first();

        return view('admin.legislation.monograph.show', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'legislation',
            'cover',
            'attachment',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function edit(Legislation $legislation)
    {
        $monograph = $legislation;

        $pageHeader = 'Ubah Monografi Hukum';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('admin.legislation.monograph.index') => 'Monografi Hukum',
            'Ubah' => TRUE
        ];

        $categories = Category::ofType(2)->pluck('name', 'id');
        $fields = Field::sorted()->pluck('name', 'id');

        $cover = $legislation->documents()
            ->ofType('cover')
            ->first();

        $attachment = $legislation->documents()
            ->ofType('attachment')
            ->first();

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
        ];

        return view('admin.legislation.monograph.edit', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'monograph',
            'categories',
            'fields',
            'cover',
            'attachment',
            'vendors',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function update(MonographRequest $request, Legislation $legislation)
    {
        $validated = $request->validated();

        if ($request->has('draft')) {
            $validated['published_at'] = null;
        }

        $legislation->update($validated);

        $this->documentUpload($legislation, $request);

        if ($legislation->wasChanged()) {
            $legislation->logs()->create([
                'user_id'   => $request->user()->id,
                'message'   => 'memperbarui data monografi',
            ]);
            $typeMessage = 'message';
            $message = '<strong>Berhasil!</strong> Data Monografi telah berhasil diperbarui';
        } else {
            $typeMessage = 'info-message';
            $message = 'Data Monografi tidak ada perubahan';
        }

        return redirect('/admin/legislation/monograph/' . $legislation->id . '/edit')->with($typeMessage, $message);
    }

    public function trigger(Request $request)
    {
        $ids = $request->items;
        $count = count($ids);

        $message = 'data Monografi telah berhasil diperbarui';
        foreach ($ids as $id)
        {
            $legislation = Legislation::withTrashed()->find($id);
            if ($request->action === 'category')
            {
                $legislation->category_id = $request->val;
                $legislation->save();

                $new_category = Category::find($request->val);

                $legislation->logs()->create([
                    'user_id'   => $request->user()->id,
                    'message'   => 'mengubah jenis monografi menjadi ' . Str::title($new_category->name),
                ]);
            }
            else if ($request->action === 'trash')
            {
                $legislation->delete();
                $message = 'data Monografi telah berhasil dibuang';

                $legislation->logs()->create([
                    'user_id'   => $request->user()->id,
                    'message'   => 'membuang monografi',
                ]);
            }
            else if ($request->action === 'delete')
            {
                $this->deleteDocuments($legislation);
                $legislation->forceDelete();
                $message = 'data Monografi telah berhasil dihapus';
            }
        }

        $request->session()->flash('message', '<span class="badge rounded-pill bg-success">' . $count . '</span> ' . $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Legislation $legislation)
    {
        $action = route('admin.legislation.monograph.restore', $legislation->id);
        $legislation->delete();

        $legislation->logs()->create([
            'user_id'   => request()->user()->id,
            'message'   => 'membuang monografi',
        ]);

        return redirect('/admin/legislation/monograph')->with('trash-message', ['<strong>Berhasil!</strong> Data Monografi telah dibuang ke Sampah', $action]);
    }

    public function restore(Legislation $legislation)
    {
        $legislation->restore();

        $legislation->logs()->create([
            'user_id'   => request()->user()->id,
            'message'   => 'mengembalikan monografi',
        ]);

        return redirect()->back()->with('message', 'Data Monografi telah dikembalikan dari Sampah');
    }

    public function forceDestroy(Legislation $legislation)
    {
        // Remove all documents
        $this->deleteDocuments($legislation->id);

        $legislation->forceDelete();

        return redirect('/admin/legislation/monograph?tab=trash')->with('message', '<strong>Berhasil!</strong> Data Monografi telah berhasil dihapus');
    }
}
