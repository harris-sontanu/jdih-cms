<?php

namespace App\Http\Controllers\Admin\Legislation;

use App\Enums\LawRelationshipStatus;
use App\Enums\LegislationDocumentType;
use App\Enums\LegislationRelationshipType;
use App\Enums\LegislationStatus;
use App\Http\Controllers\Admin\Legislation\LegislationController;
use App\Models\Category;
use App\Models\Matter;
use App\Models\Legislation;
use App\Models\Institute;
use App\Models\Field;
use App\Models\User;
use App\Http\Requests\LawRequest;
use App\Http\Requests\LawRelationshipRequest;
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

        $laws = Legislation::ofType(1)->with(['category', 'user']);

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

        $laws = $laws->search($request->only(['search']))
            ->filter($request)
            ->sorted($request->only(['order', 'sort']))
            ->paginate($request->limit ?: $this->limit)
            ->withQueryString();

        $tabFilters = $this->tabFilters($request);

        $categories = Category::ofType(1)->pluck('name', 'id');
        $matters = Matter::sorted()->pluck('name', 'id');
        $institutes = Institute::sorted()->pluck('name', 'id');
        $fields = Field::sorted()->pluck('name', 'id');
        $users = User::sorted()->pluck('name', 'id');
        $lawStatusOptions = [
            LegislationStatus::BERLAKU,
            LegislationStatus::TIDAKBERLAKU
        ];

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
            'lawStatusOptions',
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
            'sampah'    => Legislation::ofType(1)
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

        $categories = Category::ofType(1)->pluck('name', 'id');
        $statusOptions = LawRelationshipStatus::cases();
        $matters = Matter::sorted()->pluck('name', 'id');
        $institutes = Institute::sorted()->pluck('name', 'id');
        $fields = Field::sorted()->pluck('name', 'id');
        $lawStatusOptions = [
            LegislationStatus::BERLAKU,
            LegislationStatus::TIDAKBERLAKU
        ];

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
            'lawStatusOptions',
            'statusOptions',
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
        if ($request->has('relatedTo'))
        {   
            foreach ($request->relatedTo as $key => $value) {
                $type = LegislationRelationshipType::from($request['typeRelationship'][$key]);
                $status = LawRelationshipStatus::tryFrom($request['statusRelationship'][$key]);
                $related = Legislation::find($value);

                $this->storeRelationship($legislation, $related, $type, $status, $request['noteRelationship'][$key]);
            }
        }
    }

    private function documentUpload($legislation, $request)
    {
        if ($request->hasFile('master'))
        {
            $file = $request->file('master');

            $this->storeDocument($file, $legislation, LegislationDocumentType::MASTER);

            $legislation->logs()->create([
                'user_id'   => $request->user()->id,
                'message'   => 'mengunggah dokumen Batang Tubuh',
            ]);
        }

        if ($request->hasFile('abstract'))
        {
            $file = $request->file('abstract');

            $this->storeDocument($file, $legislation, LegislationDocumentType::ABSTRACT);

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

                $this->storeDocument($attachment, $legislation, LegislationDocumentType::ATTACHMENT, $i);

                $legislation->logs()->create([
                    'user_id'   => $request->user()->id,
                    'message'   => 'mengunggah dokumen Lampiran',
                ]);

                $i++;
            }
        }
    }

    private function storeRelationship(Legislation $parent, Legislation $related, ?LegislationRelationshipType $type, ?LawRelationshipStatus $status, ?string $note)
    {
        // Store related legislation
        $parent->relations()->create([
            'related_to'=> $related->id,
            'type'      => $type,
            'status'    => $status,
            'note'      => $note,
        ]);

        $msg = isset($status) ? ' <span class="fw-semibold">' . $status->label() . '</span>' : null; 

        $parent->logs()->create([
            'user_id'   => request()->user()->id,
            'message'   => 'menambahkan ' . $type->logMessage() . $msg . ' <a href="' . route('admin.legislation.law.show', $related->id) . '" target="_blank">' . $related->title . '</a>',
        ]);

        // Insert related legislation with antonym status
        if ($type == LegislationRelationshipType::STATUS OR $type == LegislationRelationshipType::LEGISLATION) {
            $related->relations()->create([
                'related_to'  => $parent->id,
                'type'        => $type,
                'status'      => $status->antonym(),
            ]);

            $related->logs()->create([
                'user_id'   => request()->user()->id,
                'message'   => 'menambahkan ' . $type->logMessage() . ' <span class="fw-semibold">' . $status->antonymLabel() . '</span> <a href="' . route('admin.legislation.law.show', $parent->id) . '" target="_blank">' . $parent->title . '</a>',
            ]);
        }
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

        $relationships = $legislation->relations()->get();

        $masterDoc = $legislation->documents()
            ->ofType(LegislationDocumentType::MASTER->name)
            ->first();

        $adobeKey = Config::get('services.adobe.key');

        return view('admin.legislation.law.show', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'legislation',
            'relationships',
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

        $categories = Category::ofType(1)->pluck('name', 'id');
        $statusOptions = LawRelationshipStatus::cases();
        $matters = Matter::sorted()->pluck('name', 'id');
        $institutes = Institute::sorted()->pluck('name', 'id');
        $fields = Field::sorted()->pluck('name', 'id');
        $lawStatusOptions = [
            LegislationStatus::BERLAKU,
            LegislationStatus::TIDAKBERLAKU
        ];
        
        $relationships = $legislation->relations()->get();

        $showUploadForm = [
            'master'    => true,
            'abstract'  => true
        ];

        foreach ($legislation->documents as $document) {
            if ($document->type === LegislationDocumentType::MASTER) {
                $showUploadForm['master'] = false;
            }
            if ($document->type === LegislationDocumentType::ABSTRACT) {
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
            'lawStatusOptions',
            'statusOptions',
            'relationships',
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
                $this->deleteDocuments($law);
                $law->forceDelete();
                $message = 'data Peraturan telah berhasil dihapus';
            }
        }

        $request->session()->flash('message', '<span class="badge rounded-pill bg-success">' . $count . '</span> ' . $message);
    }

    public function showRelationship(LawRelationshipRequest $request)
    {
        $validated = $request->validated();

        $status = $request->enum('statusOptions', LawRelationshipStatus::class);
        $law = Legislation::find($validated['statusRelatedTo']);
        $note = $validated['statusNote'];
        $sequence = $request->sequence;
        $type = $request->enum('type', LegislationRelationshipType::class);

        $parent = null;
        if ($request->has('id')) {
            $parent = Legislation::find($request->id);
            $this->storeRelationship($parent, $law, $type, $status, $note);
        }

        return view('admin.legislation.law.tab.show-relationship', compact(
            'type',
            'status',
            'law',
            'note',
            'sequence',
            'parent',
        ));
    }

    public function relationshipDestroy(Request $request, Legislation $legislation)
    {
        $relatedToId = $request->relatedId;
        $type = $request->enum('type', LegislationRelationshipType::class);
        $status = $request->enum('status', LawRelationshipStatus::class);

        $legislation->relations()
            ->where('related_to', $relatedToId)
            ->where('type', $type)
            ->delete();

        $related = Legislation::find($relatedToId);

        $msg = isset($status) ? ' <span class="fw-semibold">' . $status->label() . '</span>' : null;
        $legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'menghapus ' . $type->logMessage() . $msg . ' <a href="' . route('admin.legislation.law.show', $related->id) . '" target="_blank">' . $related->title . '</a>',
        ]);

        // Delete also related Legislation
        if ($type == LegislationRelationshipType::STATUS OR $type == LegislationRelationshipType::LEGISLATION) {
            $related->relations()
                ->where('related_to', $legislation->id)
                ->where('type', $type)
                ->delete();

            $related->logs()->create([
                'user_id'   => $request->user()->id,
                'message'   => 'menghapus ' . $type->logMessage() . ' <span class="fw-semibold">' . $status->antonymLabel() . '</span> <a href="' . route('admin.legislation.law.show', $legislation->id) . '" target="_blank">' . $legislation->title . '</a>',
            ]);
        }
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
        $this->deleteDocuments($legislation);

        $legislation->forceDelete();

        return redirect('/admin/legislation/law?tab=trash')->with('message', '<strong>Berhasil!</strong> Data Peraturan telah berhasil dihapus');
    }
}
