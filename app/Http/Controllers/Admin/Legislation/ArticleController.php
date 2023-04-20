<?php

namespace App\Http\Controllers\Admin\Legislation;

use App\Enums\LegislationDocumentType;
use App\Http\Controllers\Admin\Legislation\LegislationController;
use App\Models\Legislation;
use App\Models\Category;
use App\Models\Field;
use App\Models\User;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArticlesExport;

class ArticleController extends LegislationController
{
    public function __construct()
    {
        $this->authorizeResource(Legislation::class, 'article');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Artikel Hukum';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            'Artikel Hukum' => TRUE
        ];

        $articles = Legislation::ofType(3);

        $onlyTrashed = FALSE;
        if ($tab = $request->tab)
        {
            if ($tab === 'sampah') {
                $articles->onlyTrashed();
                $onlyTrashed = TRUE;
            } else if ($tab === 'terbit') {
                $articles->published();
            } else if ($tab === 'terjadwal') {
                $articles->scheduled();
            } else if ($tab === 'draf') {
                $articles->draft();
            }
        }

        $articles = $articles->search($request->only(['search']))
            ->filter($request)
            ->sorted($request->only(['order', 'sort']))
            ->paginate($request->limit ?: $this->limit)
            ->withQueryString();

        $tabFilters = $this->tabFilters($request);

        $categories = Category::ofType(3)->pluck('name', 'id');
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

        return view('admin.legislation.article.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'onlyTrashed',
            'articles',
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
            'total'     => Legislation::ofType(3)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->count(),
            'draf'      => Legislation::ofType(3)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->draft()
                                ->count(),
            'terbit'    => Legislation::ofType(3)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->published()
                                ->count(),
            'terjadwal' => Legislation::ofType(3)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->scheduled()
                                ->count(),
            'sampah'     => Legislation::ofType(3)
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
            return Excel::download(new ArticlesExport($array_id, $request->order, $request->sort), 'artikel.xlsx');
        }
        else if ($format === 'pdf')
        {
            return (new ArticlesExport($array_id, $request->order, $request->sort))
                ->download('artikel.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Tambah Artikel Hukum';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('admin.legislation.article.index') => 'Artikel Hukum',
            'Tambah' => TRUE
        ];

        $categories = Category::ofType(3)->pluck('name', 'id');
        $fields = Field::sorted()->pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
        ];

        return view('admin.legislation.article.create', compact(
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
    public function store(ArticleRequest $request)
    {
        $validated = $request->validated();

        $message = 'menambahkan artikel';
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

        return redirect('/admin/legislation/article')->with('message', '<strong>Berhasil!</strong> Data Artikel baru telah berhasil disimpan');
    }

    private function documentUpload($legislation, $request)
    {
        if ($request->hasFile('cover'))
        {
            $this->storeDocument($request->file('cover'), $legislation, LegislationDocumentType::COVER);

            $legislation->logs()->create([
                'user_id'   => $request->user()->id,
                'message'   => 'mengunggah dokumen Sampul',
            ]);
        }

        if ($request->hasFile('attachment'))
        {
            $this->storeDocument($request->file('attachment'), $legislation, LegislationDocumentType::MASTER);

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
            route('admin.legislation.article.index') => 'Artikel Hukum',
            'Detail' => TRUE
        ];

        $cover = $legislation->documents()
            ->ofType(LegislationDocumentType::COVER->name)
            ->first();

        $attachment = $legislation->documents()
            ->ofType(LegislationDocumentType::MASTER->name)
            ->first();

        return view('admin.legislation.article.show', compact(
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
        $article = $legislation;

        $pageHeader = 'Ubah Artikel Hukum';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('admin.legislation.article.index') => 'Artikel Hukum',
            'Ubah' => TRUE
        ];

        $categories = Category::ofType(3)->pluck('name', 'id');
        $fields = Field::sorted()->pluck('name', 'id');

        $cover = $legislation->documents()
            ->ofType(LegislationDocumentType::COVER->name)
            ->first();

        $attachment = $legislation->documents()
            ->ofType(LegislationDocumentType::MASTER->name)
            ->first();

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
        ];

        return view('admin.legislation.article.edit', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'article',
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
    public function update(ArticleRequest $request, Legislation $legislation)
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
                'message'   => 'memperbarui data artikel',
            ]);
            $typeMessage = 'message';
            $message = '<strong>Berhasil!</strong> Data Artikel telah berhasil diperbarui';
        } else {
            $typeMessage = 'info-message';
            $message = 'Data Artikel tidak ada perubahan';
        }

        return redirect('/admin/legislation/article/' . $legislation->id . '/edit')->with($typeMessage, $message);
    }

    public function trigger(Request $request)
    {
        $ids = $request->items;
        $count = count($ids);

        $message = 'data Artikel telah berhasil diperbarui';
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
                    'message'   => 'mengubah jenis artikel menjadi ' . Str::title($new_category->name),
                ]);
            }
            else if ($request->action === 'trash')
            {
                $legislation->delete();
                $message = 'data Artikel telah berhasil dibuang';

                $legislation->logs()->create([
                    'user_id'   => $request->user()->id,
                    'message'   => 'membuang artikel',
                ]);
            }
            else if ($request->action === 'delete')
            {
                $this->deleteDocuments($legislation);
                $legislation->forceDelete();
                $message = 'data Artikel telah berhasil dihapus';
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
        $action = route('admin.legislation.article.restore', $legislation->id);
        $legislation->delete();

        $legislation->logs()->create([
            'user_id'   => request()->user()->id,
            'message'   => 'membuang artikel',
        ]);

        return redirect('/admin/legislation/article')->with('trash-message', ['<strong>Berhasil!</strong> Data Artikel telah dibuang ke Sampah', $action]);
    }

    public function restore(Legislation $legislation)
    {
        $legislation->restore();

        $legislation->logs()->create([
            'user_id'   => request()->user()->id,
            'message'   => 'mengembalikan artikel',
        ]);

        return redirect()->back()->with('message', 'Data Artikel telah dikembalikan dari Sampah');
    }

    public function forceDestroy(Legislation $legislation)
    {
        // Remove all documents
        $this->deleteDocuments($legislation->id);

        $legislation->forceDelete();

        return redirect('/admin/legislation/article?tab=trash')->with('message', '<strong>Berhasil!</strong> Data Artikel telah berhasil dihapus');
    }
}
