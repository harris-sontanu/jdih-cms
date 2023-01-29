<?php

namespace App\Http\Controllers\Admin\Legislation;

use App\Http\Controllers\Admin\Legislation\LegislationController;
use App\Models\Category;
use App\Models\Matter;
use App\Models\Legislation;
use App\Models\Institute;
use App\Models\Field;
use App\Models\User;
use App\Http\Requests\LawRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LawsExport;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class LawController extends LegislationController
{
    public function __construct()
    {
        $this->authorizeResource(Legislation::class, 'law');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Peraturan Perundang-undangan';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            'Peraturan Perundang-undangan' => TRUE
        ];

        $laws = Legislation::ofType(1)->with('user');

        $onlyTrashed = FALSE;
        if ($tab = $request->tab)
        {
            if ($tab === 'sampah') {
                $laws->onlyTrashed();
                $onlyTrashed = TRUE;
            } else if ($tab === 'terbit') {
                $laws->published();
            } else if ($tab === 'terjadwal') {
                $laws->scheduled();
            } else if ($tab === 'draf') {
                $laws->draft();
            }
        }

        $limit = !empty($request->limit) ? $request->limit : $this->limit;

        $laws = $laws->search($request->only(['search']))
            ->filter($request)
            ->sorted($request->only(['order', 'sort']))
            ->paginate($limit)
            ->withQueryString();

        $tabFilters = $this->tabFilters($request);

        $categories = Category::laws()->pluck('name', 'id');
        $matters = Matter::sorted()->pluck('name', 'id');
        $institutes = Institute::sorted()->pluck('name', 'id');
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

        return view('admin.legislation.law.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'onlyTrashed',
            'laws',
            'categories',
            'matters',
            'institutes',
            'fields',
            'users',
            'tabFilters',
            'vendors'
        ));
    }

    private function tabFilters($request)
    {
        return [
            'total'     => Legislation::ofType(1)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->count(),
            'draf'      => Legislation::ofType(1)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->draft()
                                ->count(),
            'terbit'    => Legislation::ofType(1)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->published()
                                ->count(),
            'terjadwal' => Legislation::ofType(1)
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->scheduled()
                                ->count(),
            'sampah'     => Legislation::ofType(1)
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
            return Excel::download(new LawsExport($array_id, $request->order, $request->sort), 'peraturan.xlsx');
        }
        else if ($format === 'pdf')
        {
            return (new LawsExport($array_id, $request->order, $request->sort))
                ->download('peraturan.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Tambah Peraturan Perundang-undangan';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('admin.legislation.law.index') => 'Peraturan Perundang-undangan',
            'Tambah' => TRUE
        ];

        $categories = Category::laws()->pluck('name', 'id');
        $statusOptions = $this->statusOptions;
        $lawRelationshipOptions = $this->lawRelationshipOptions;
        $matters = Matter::sorted()->pluck('name', 'id');
        $institutes = Institute::sorted()->pluck('name', 'id');
        $fields = Field::sorted()->pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
        ];

        return view('admin.legislation.law.create', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'categories',
            'matters',
            'institutes',
            'fields',
            'statusOptions',
            'lawRelationshipOptions',
            'vendors',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LawRequest $request)
    {
        $validated = $request->validated();

        $message = 'menambahkan peraturan';
        if ($request->has('draft')) {
            $validated['published_at'] = null;
            $message .= ' sebagai Draf';
        }

        $new_legislation = $request->user()->legislations()->create($validated);

        $new_legislation->matters()->attach($request->matter);

        $new_legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => $message,
        ]);

        $this->relationship($new_legislation, $request);

        $this->documentUpload($new_legislation, $request);

        return redirect('/admin/legislation/law')->with('message', '<strong>Berhasil!</strong> Data Peraturan baru telah berhasil disimpan');
    }

    private function relationship($legislation, $request)
    {
        if ($request->has('statusOptions'))
        {
            foreach ($request['statusOptions'] as $key => $value) {
                $relatedToId = (int)$request['statusRelatedTo'][$key];
                $related = Legislation::find($relatedToId);

                $this->storeStatusRelationship($legislation, $related, $value, $request['statusNote'][$key]);
            }
        }

        if ($request->has('lawRelationshipOptions'))
        {
            foreach ($request['lawRelatedTo'] as $key => $relatedToId) {
                $related = Legislation::find($relatedToId);

                $this->storeLawRelationship($legislation, $related, $request['lawRelationshipOptions'][$key], $request['lawRelatedNote'][$key]);
            }
        }

        if ($request->has('docRelatedTo'))
        {
            foreach ($request['docRelatedTo'] as $key => $relatedToId) {
                $related = Legislation::find($relatedToId);

                $this->storeDocRelationship($legislation, $related, $request['docRelatedNote'][$key]);
            }
        }
    }

    private function documentUpload($legislation, $request)
    {
        if ($request->hasFile('master'))
        {
            $file = $request->file('master');

            $mediaId = $this->storeDocument($file, $legislation, 'master');

            $legislation->documents()->create([
                'media_id'  => $mediaId,
                'type'      => 'master',
            ]);

            $legislation->logs()->create([
                'user_id'   => $request->user()->id,
                'message'   => 'mengunggah dokumen Batang Tubuh',
            ]);
        }

        if ($request->hasFile('abstract'))
        {
            $file = $request->file('abstract');

            $mediaId = $this->storeDocument($file, $legislation, 'abstract');

            $legislation->documents()->create([
                'media_id'  => $mediaId,
                'type'      => 'abstract',
            ]);

            $legislation->logs()->create([
                'user_id'   => $request->user()->id,
                'message'   => 'mengunggah dokumen Abstrak',
            ]);
        }

        if ($request->hasFile('attachment'))
        {
            $files = $request->file('attachment');

            // Get the next order
            $currentOrder = $legislation->documents->where('type', 'attachment')->max('order');
            $i = isset($currentOrder) ? $currentOrder + 1 : 1;

            foreach ($files as $attachment) {

                $mediaId = $this->storeDocument($attachment, $legislation, 'attachment');

                $legislation->documents()->create([
                    'media_id'  => $mediaId,
                    'type'      => 'attachment',
                    'order'     => $i,
                ]);

                $legislation->logs()->create([
                    'user_id'   => $request->user()->id,
                    'message'   => 'mengunggah dokumen Lampiran',
                ]);

                $i++;
            }
        }
    }

    private function storeStatusRelationship($parent, $related, $status, $note)
    {
        // Insert related legislation
        $parent->relations()->create([
            'related_to'=> $related->id,
            'type'      => 'status',
            'status'    => $status,
            'note'      => $note,
        ]);

        $parent->logs()->create([
            'user_id'   => request()->user()->id,
            'message'   => 'menambahkan keterangan status <span class="fw-semibold">' . $status . '</span> <a href="' . route('admin.legislation.law.show', $related->id) . '" target="_blank">' . $related->title . '</a>',
        ]);

        // Insert related legislation with antonym status
        $antonymStatus = $this->statusAntonym($status);
        $related->relations()->create([
            'related_to'  => $parent->id,
            'type'        => 'status',
            'status'      => $antonymStatus,
        ]);

        $related->logs()->create([
            'user_id'   => request()->user()->id,
            'message'   => 'menambahkan keterangan status <span class="fw-semibold">' . $antonymStatus . '</span> <a href="' . route('admin.legislation.law.show', $parent->id) . '" target="_blank">' . $parent->title . '</a>',
        ]);
    }

    private function storeLawRelationship($parent, $related, $status, $note)
    {
        $parent->relations()->create([
            'related_to'=> $related->id,
            'type'      => 'legislation',
            'status'    => $status,
            'note'      => $note,
        ]);

        $parent->logs()->create([
            'user_id'   => request()->user()->id,
            'message'   => 'menambahkan peraturan terkait <span class="fw-semibold">' . $status . '</span> <a href="' . route('admin.legislation.law.show', $related->id) . '" target="_blank">' . $related->title . '</a>',
        ]);
    }

    private function storeDocRelationship($parent, $related, $note)
    {
        $parent->relations()->create([
            'related_to'=> $related->id,
            'type'      => 'document',
            'note'      => $note,
        ]);

        $parent->logs()->create([
            'user_id'   => request()->user()->id,
            'message'   => 'menambahkan dokumen terkait <a href="' . route('admin.legislation.law.show', $related->id) . '" target="_blank">' . $related->title . '</a>',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Legislation $legislation)
    {
        $pageHeader = $legislation->category->abbrev . ' Nomor ' . $legislation->code_number . ' Tahun ' . $legislation->year;
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('admin.legislation.law.index') => 'Peraturan Perundang-undangan',
            'Detail' => TRUE
        ];

        $statusRelationships = $legislation->relations()->where('type', 'status')->get();
        $lawRelationships = $legislation->relations()->where('type', 'legislation')->get();
        $documentRelationships = $legislation->relations()->where('type', 'document')->get();

        $masterDoc = $legislation->documents()
            ->ofType('master')
            ->first();

        $adobeKey = Config::get('services.adobe.key');

        return view('admin.legislation.law.show', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'legislation',
            'statusRelationships',
            'lawRelationships',
            'documentRelationships',
            'masterDoc',
            'adobeKey',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Legislation $legislation)
    {
        $law = $legislation;

        $pageHeader = 'Ubah Peraturan Perundang-undangan';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('admin.legislation.law.index') => 'Peraturan Perundang-undangan',
            'Ubah' => TRUE
        ];

        $categories = Category::laws()->pluck('name', 'id');
        $statusOptions = $this->statusOptions;
        $lawRelationshipOptions = $this->lawRelationshipOptions;
        $matters = Matter::sorted()->pluck('name', 'id');
        $institutes = Institute::sorted()->pluck('name', 'id');
        $fields = Field::sorted()->pluck('name', 'id');

        $statusRelationships = $legislation->relations()->where('type', 'status')->get();
        $lawRelationships = $legislation->relations()->where('type', 'legislation')->get();
        $documentRelationships = $legislation->relations()->where('type', 'document')->get();

        $showUploadForm = [
            'master'    => true,
            'abstract'  => true
        ];

        foreach ($legislation->documents as $document) {
            if ($document->type === 'master') {
                $showUploadForm['master'] = false;
            }
            if ($document->type === 'abstract') {
                $showUploadForm['abstract'] = false;
            }
        }

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
        ];

        return view('admin.legislation.law.edit', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'law',
            'categories',
            'matters',
            'institutes',
            'fields',
            'statusOptions',
            'lawRelationshipOptions',
            'statusRelationships',
            'lawRelationships',
            'documentRelationships',
            'showUploadForm',
            'vendors',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LawRequest $request, Legislation $legislation)
    {
        $validated = $request->validated();

        if ($request->has('draft')) {
            $validated['published_at'] = null;
        }

        $legislation->update($validated);

        $legislation->matters()->sync($request->matter);

        $this->documentUpload($legislation, $request);

        if ($legislation->wasChanged()) {
            $legislation->logs()->create([
                'user_id'   => $request->user()->id,
                'message'   => 'memperbarui data peraturan',
            ]);
            $typeMessage = 'message';
            $message = '<strong>Berhasil!</strong> Data Peraturan telah berhasil diperbarui';
        } else {
            $typeMessage = 'info-message';
            $message = 'Data Peraturan tidak ada perubahan';
        }

        return redirect('/admin/legislation/law/' . $legislation->id . '/edit')->with($typeMessage, $message);
    }

    public function trigger(Request $request)
    {
        $ids = $request->items;
        $count = count($ids);

        $message = 'data Peraturan telah berhasil diperbarui';
        foreach ($ids as $id)
        {
            $law = Legislation::withTrashed()->find($id);
            if ($request->action === 'status')
            {
                $law->status = $request->val;
                $law->save();

                $law->logs()->create([
                    'user_id'   => $request->user()->id,
                    'message'   => 'mengubah status peraturan menjadi ' . Str::title($request->val),
                ]);
            }
            else if ($request->action === 'category')
            {
                $law->category_id = $request->val;
                $law->save();

                $new_category = Category::find($request->val);

                $law->logs()->create([
                    'user_id'   => $request->user()->id,
                    'message'   => 'mengubah jenis peraturan menjadi ' . Str::title($new_category->name),
                ]);
            }
            else if ($request->action === 'trash')
            {
                $law->delete();
                $message = 'data Peraturan telah berhasil dibuang';

                $law->logs()->create([
                    'user_id'   => $request->user()->id,
                    'message'   => 'membuang peraturan',
                ]);
            }
            else if ($request->action === 'delete')
            {
                $law->forceDelete();
                $message = 'data Peraturan telah berhasil dihapus';
            }
        }

        $request->session()->flash('message', '<span class="badge rounded-pill bg-success">' . $count . '</span> ' . $message);
    }

    public function statusRelationshipRow(Request $request)
    {
        $validated = $request->validate([
            'statusOptions' => 'required',
            'statusRelatedTo' => 'required',
            'statusNote'      => 'nullable',
        ]);

        $status = $validated['statusOptions'];
        $law = Legislation::find($validated['statusRelatedTo']);
        $note = $validated['statusNote'];
        $sequence = $request->sequence;

        $parent = null;
        if ($request->has('id')) {
            $parent = Legislation::find($request->id);
            $this->storeStatusRelationship($parent, $law, $status, $note);
        }

        return view('admin.legislation.law.tab.status-relationship-row', compact(
            'status',
            'law',
            'note',
            'sequence',
            'parent',
        ));
    }

    public function statusRelationshipDestroy(Request $request, Legislation $legislation)
    {
        $related_to = $request->relatedId;
        $status = $request->status;

        $legislation->relations()
            ->where('related_to', $related_to)
            ->where('type', 'status')
            ->delete();

        $related = Legislation::find($related_to);

        $legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'menghapus keterangan status <span class="fw-semibold">' . $status . '</span> <a href="' . route('admin.legislation.law.show', $related->id) . '" target="_blank">' . $related->title . '</a>',
        ]);

        // Delete also related Legislation
        $antonymStatus = $this->statusAntonym($status);
        $related->relations()
            ->where('related_to', $legislation->id)
            ->where('type', 'status')
            ->delete();

        $related->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'menghapus keterangan status <span class="fw-semibold">' . $antonymStatus . '</span> <a href="' . route('admin.legislation.law.show', $legislation->id) . '" target="_blank">' . $legislation->title . '</a>',
        ]);
    }

    public function lawRelationshipRow(Request $request)
    {
        $validated = $request->validate([
            'lawRelationshipOptions' => 'required',
            'lawRelatedTo'      => 'required',
            'lawRelatedNote'    => 'nullable',
        ]);

        $lawRelationshipOptions = $this->lawRelationshipOptions;
        $status = $lawRelationshipOptions[$request->lawRelationshipOptions];
        $law = Legislation::find($request->lawRelatedTo);
        $note = $request->lawRelatedNote;
        $sequence = $request->sequence;

        $parent = null;
        if ($request->has('id')) {
            $parent = Legislation::find($request->id);
            $this->storeLawRelationship($parent, $law, $request->lawRelationshipOptions, $note);
        }

        return view('admin.legislation.law.tab.law-relationship-row', compact(
            'status',
            'law',
            'note',
            'sequence',
            'parent',
        ));
    }

    public function lawRelationshipDestroy(Request $request, Legislation $legislation)
    {
        $related_to = $request->relatedId;
        $status = $request->status;

        $legislation->relations()
            ->where('related_to', $related_to)
            ->where('type', 'legislation')
            ->delete();

        $related = Legislation::find($related_to);

        $legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'menghapus peraturan terkait <span class="fw-semibold">' . $status . '</span> <a href="' . route('admin.legislation.law.show', $related->id) . '" target="_blank">' . $related->title . '</a>',
        ]);
    }

    public function docRelationshipRow(Request $request)
    {
        $validated = $request->validate([
            'docRelatedTo'      => 'required',
            'docRelatedNote'    => 'nullable',
        ]);

        $doc = Legislation::find($request->docRelatedTo);
        $note = $request->docRelatedNote;
        $sequence = $request->sequence;

        $parent = null;
        if ($request->has('id')) {
            $parent = Legislation::find($request->id);
            $this->storeDocRelationship($parent, $doc, $note);
        }

        return view('admin.legislation.law.tab.doc-relationship-row', compact(
            'doc',
            'note',
            'sequence',
            'parent'
        ));
    }

    public function docRelationshipDestroy(Request $request, Legislation $legislation)
    {
        $related_to = $request->relatedId;

        $legislation->relations()
            ->where('related_to', $related_to)
            ->where('type', 'document')
            ->delete();

        $related = Legislation::find($related_to);

        $legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'menghapus dokumen terkait <a href="' . route('admin.legislation.law.show', $related->id) . '" target="_blank">' . $related->title . '</a>',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Legislation $legislation)
    {
        $action = route('admin.legislation.law.restore', $legislation->id);
        $legislation->delete();

        $legislation->logs()->create([
            'user_id'   => request()->user()->id,
            'message'   => 'membuang peraturan',
        ]);

        return redirect('/admin/legislation/law')->with('trash-message', ['<strong>Berhasil!</strong> Data Peraturan telah dibuang ke Sampah', $action]);
    }

    public function restore(Legislation $legislation)
    {
        $legislation->restore();

        $legislation->logs()->create([
            'user_id'   => request()->user()->id,
            'message'   => 'mengembalikan peraturan',
        ]);

        return redirect()->back()->with('message', 'Data Peraturan telah dikembalikan dari Sampah');
    }

    public function forceDestroy(Legislation $legislation)
    {
        // Remove all documents
        $this->deleteDocuments($legislation->id);

        $legislation->forceDelete();

        return redirect('/admin/legislation/law?tab=trash')->with('message', '<strong>Berhasil!</strong> Data Peraturan telah berhasil dihapus');
    }
}
