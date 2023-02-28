<?php

namespace App\Http\Controllers\Admin\Legislation;

use App\Http\Controllers\Admin\Legislation\LegislationController;
use App\Models\Legislation;
use App\Models\Category;
use App\Models\Field;
use App\Models\User;
use App\Http\Requests\JudgmentRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JudgmentsExport;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class JudgmentController extends LegislationController
{
    public function __construct()
    {
        $this->authorizeResource(Legislation::class, 'judgment');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Putusan Pengadilan';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            'Putusan Pengadilan' => TRUE
        ];

        $judgments = Legislation::ofType(4);

        $onlyTrashed = FALSE;
        if ($tab = $request->tab)
        {
            if ($tab === 'sampah') {
                $judgments->onlyTrashed();
                $onlyTrashed = TRUE;
            } else if ($tab === 'terbit') {
                $judgments->published();
            } else if ($tab === 'terjadwal') {
                $judgments->scheduled();
            } else if ($tab === 'draf') {
                $judgments->draft();
            }
        }

        $limit = !empty($request->limit) ? $request->limit : $this->limit;

        $judgments = $judgments->search($request->only(['search']))
            ->filter($request)
            ->sorted($request->only(['order', 'sort']))
            ->paginate($limit)
            ->withQueryString();

        $tabFilters = $this->tabFilters($request);

        $categories = Category::ofType(4)->pluck('name', 'id');
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

        return view('admin.legislation.judgment.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'onlyTrashed',
            'judgments',
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
            'total'     => Legislation::ofType(4)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->count(),
            'draf'      => Legislation::ofType(4)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->draft()
                                ->count(),
            'terbit'    => Legislation::ofType(4)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->published()
                                ->count(),
            'terjadwal' => Legislation::ofType(4)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->scheduled()
                                ->count(),
            'sampah'    => Legislation::ofType(4)
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
            return Excel::download(new JudgmentsExport($array_id, $request->order, $request->sort), 'putusan.xlsx');
        }
        else if ($format === 'pdf')
        {
            return (new JudgmentsExport($array_id, $request->order, $request->sort))
                ->download('putusan.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Tambah Putusan Pengadilan';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('admin.legislation.judgment.index') => 'Putusan Pengadilan',
            'Tambah' => TRUE
        ];

        $categories = Category::ofType(4)->pluck('name', 'id');
        $fields = Field::sorted()->pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
        ];

        return view('admin.legislation.judgment.create', compact(
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
    public function store(JudgmentRequest $request)
    {
        $validated = $request->validated();

        $message = 'menambahkan putusan';
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

        return redirect('/admin/legislation/judgment')->with('message', '<strong>Berhasil!</strong> Data Putusan baru telah berhasil disimpan');
    }

    private function documentUpload($legislation, $request)
    {
        if ($request->hasFile('master'))
        {
            $this->storeDocument($request->file('master'), $legislation, 'master');

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
            route('admin.legislation.judgment.index') => 'Putusan Pengadilan',
            'Detail' => TRUE
        ];

        $attachment = $legislation->documents()
            ->ofType('master')
            ->first();

        $adobeKey = Config::get('services.adobe.key');

        return view('admin.legislation.judgment.show', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'legislation',
            'attachment',
            'adobeKey',
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
        $judgment = $legislation;

        $pageHeader = 'Ubah Putusan Pengadilan';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('admin.legislation.judgment.index') => 'Putusan Pengadilan',
            'Ubah' => TRUE
        ];

        $categories = Category::ofType(4)->pluck('name', 'id');
        $fields = Field::sorted()->pluck('name', 'id');

        $attachment = $legislation->documents()
            ->ofType('master')
            ->first();

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
        ];

        return view('admin.legislation.judgment.edit', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'judgment',
            'categories',
            'fields',
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
    public function update(JudgmentRequest $request, Legislation $legislation)
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
                'message'   => 'memperbarui data putusan',
            ]);
            $typeMessage = 'message';
            $message = '<strong>Berhasil!</strong> Data Putusan telah berhasil diperbarui';
        } else {
            $typeMessage = 'info-message';
            $message = 'Data Putusan tidak ada perubahan';
        }

        return redirect('/admin/legislation/judgment/' . $legislation->id . '/edit')->with($typeMessage, $message);
    }

    public function trigger(Request $request)
    {
        $ids = $request->items;
        $count = count($ids);

        $message = 'data Putusan telah berhasil diperbarui';
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
                    'message'   => 'mengubah jenis putusan menjadi ' . Str::title($new_category->name),
                ]);
            }
            else if ($request->action === 'trash')
            {
                $legislation->delete();
                $message = 'data Putusan telah berhasil dibuang';

                $legislation->logs()->create([
                    'user_id'   => $request->user()->id,
                    'message'   => 'membuang putusan',
                ]);
            }
            else if ($request->action === 'delete')
            {
                $this->deleteDocuments($legislation);
                $legislation->forceDelete();
                $message = 'data Putusan telah berhasil dihapus';
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
        $action = route('admin.legislation.judgment.restore', $legislation->id);
        $legislation->delete();

        $legislation->logs()->create([
            'user_id'   => request()->user()->id,
            'message'   => 'membuang putusan',
        ]);

        return redirect('/admin/legislation/judgment')->with('trash-message', ['<strong>Berhasil!</strong> Data Putusan telah dibuang ke Sampah', $action]);
    }

    public function restore(Legislation $legislation)
    {
        $legislation->restore();

        $legislation->logs()->create([
            'user_id'   => request()->user()->id,
            'message'   => 'mengembalikan putusan',
        ]);

        return redirect()->back()->with('message', 'Data Putusan telah dikembalikan dari Sampah');
    }

    public function forceDestroy(Legislation $legislation)
    {
        // Remove all documents
        $this->deleteDocuments($legislation->id);

        $legislation->forceDelete();

        return redirect('/admin/legislation/judgment?tab=trash')->with('message', '<strong>Berhasil!</strong> Data Monografi telah berhasil dihapus');
    }
}
