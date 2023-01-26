<?php

namespace App\Http\Controllers\Admin\Legislation;

use App\Http\Controllers\Admin\Legislation\LegislationController;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DocumentController extends LegislationController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        return view('admin.legislation.document.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'document' => [
                $document->type === 'attachment' ? 'sometimes' : 'required',
                'file',
                'mimes:pdf',
                'max:20480',
            ],
            'order' => [
                'sometimes',
                'numeric',
                Rule::unique('documents')->where(fn ($query) => $query->where([
                    ['legislation_id', '=', $document->legislation_id],
                    ['type', '=', 'attachment'],
                    ['id', '<>', $document->id]
                ]))
            ]
        ]);

        if ($request->hasFile('document')) {

            // Delete the old file first
            $this->removeDocument($document->path);

            $documentStorage = $this->documentStorage($document->legislation, $document->type, $document->order);
            $request->file('document')->storeAs($documentStorage['path'], $document->name, 'public');
        }

        if ($document->type === 'attachment') {
            $data = ['order' => $request->order];

            // Rename the file's path and name when new order is different
            if ($document->order !== $request->order)
            {
                $documentStorage = $this->documentStorage($document->legislation, $document->type, $request->order);
                $ext = explode('.', $document->name);
                $new_path = $documentStorage['path'] . '/' . $documentStorage['file_name'] . '.' . $ext[1];
                $new_file_name = $documentStorage['file_name'] . '.' . $ext[1];

                Storage::disk('public')->move($document->path, $new_path);

                $data['path'] = $new_path;
                $data['name'] = $new_file_name;
            }

            $document->update($data);

            $document->legislation->logs()->create([
                'user_id'   => $request->user()->id,
                'message'   => 'memperbaiki dokumen Lampiran',
            ]);
        } else {
            $document->touch();

            $documentType = $document->type === 'master' ? 'Batang Tubuh' : 'Abstrak';
            $document->legislation->logs()->create([
                'user_id'   => $request->user()->id,
                'message'   => 'memperbaiki dokumen ' . $documentType,
            ]);
        }

        $request->session()->flash('message', '<strong>Berhasil!</strong> Data Dokumen telah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document, Request $request)
    {
        $this->removeDocument($document->path);

        if ($document->type === 'master') {
            $documentType = 'Batang Tubuh';
        } else if ($document->type === 'abstract') {
            $documentType = 'Abstrak';
        } else if ($document->type === 'attachment') {
            $documentType = 'Lampiran';
        } else if ($document->type === 'cover') {
            $documentType = 'Sampul';

            // Remove thumbnail
            $ext        = substr(strrchr($document->path, '.'), 1);
            $thumbnail  = str_replace(".{$ext}", "_thumb.{$ext}", $document->path);
            $this->removeDocument($thumbnail);
        }
        $document->legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'menghapus dokumen ' . $documentType,
        ]);

        $document->delete();

        $request->session()->flash('message', '<strong>Berhasil!</strong> Data Dokumen telah berhasil dihapus');
    }
}
