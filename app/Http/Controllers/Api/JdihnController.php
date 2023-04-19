<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Legislation;

class JdihnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $laws = Legislation::ofType(1)
            ->search($request)
            ->filter($request)
            ->published()
            ->latestApproved()
            ->paginate($request->limit ?? 25);
        
        foreach ($laws as $law) {
            $document = $law->documents()->whereType('master')->first();
            $data[] = [
                'idData'    => (string)$law->id,
                'judul'     => $law->title,
                'jenis'     => $law->category_name,
                'singkatanJenis'    => $law->category_abbrev,
                'noPeraturan'   => $law->code_number,
                'tahun_pengundangan'    => (string)$law->year,
                'tanggal_pengundangan'  => $law->published,
                'sumber'    => $law->source,
                'subjek'    => $law->subject,
                'status'    => $law->status,
                'bahasa'    => $law->language,
                'teuBadan'  => $law->author,
                'urlDownload'   => isset($document->media) ? url($document->media->source) : null,
                'fileDownload'  => isset($document->media) ? $document->media->name : null,
                // 'urlDetailPeraturan'    => route('legislation.law.show', ['category' => $law->category->slug, 'legislation' => $law->slug]),
                'operasi'   => '4',
                'display'   => '1',
            ];
        }

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $law = Legislation::findOrFail($id);
        $document = $law->documents()->whereType('master')->first();
        $data = [
            'idData'    => (string)$law->id,
            'judul'     => $law->title,
            'jenis'     => $law->category_name,
            'singkatanJenis'    => $law->category_abbrev,
            'noPeraturan'   => $law->code_number,
            'tahun_pengundangan'    => (string)$law->year,
            'tanggal_pengundangan'  => $law->published,
            'sumber'    => $law->source ?? '',
            'subjek'    => $law->subject ?? '',
            'status'    => $law->status,
            'bahasa'    => $law->language ?? '',
            'teuBadan'  => $law->author ?? '',
            'urlDownload'   => isset($document->media) ? url($document->media->source) : null,
            'fileDownload'  => isset($document->media) ? $document->media->name : null,
            // 'urlDetailPeraturan'    => route('legislation.law.show', ['category' => $law->category->slug, 'legislation' => $law->slug]),
            'operasi'   => '4',
            'display'   => '1',
        ];

        return response()->json($data);
    }
}
