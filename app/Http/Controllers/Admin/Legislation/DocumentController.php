<?php

namespace App\Http\Controllers\Admin\Legislation;

use App\Http\Controllers\Admin\Legislation\LegislationController;
use Illuminate\Http\Request;
use App\Models\Media;

class DocumentController extends LegislationController
{
    public function __invoke($id, Request $request)
    {
        $media = Media::findOrFail($id);

        $this->removeDocument($media->path);

        if ($media->legislationDocument->type === 'master') {
            $documentType = 'Batang Tubuh';
        } else if ($media->legislationDocument->type === 'abstract') {
            $documentType = 'Abstrak';
        } else if ($media->legislationDocument->type === 'attachment') {
            $documentType = 'Lampiran';
        } else if ($media->legislationDocument->type === 'cover') {
            $documentType = 'Sampul';

            // Remove thumbnail
            $ext        = substr(strrchr($media->legislationDocument->path, '.'), 1);
            $thumbnail  = str_replace(".{$ext}", "_thumb.{$ext}", $media->legislationDocument->path);
            $this->removeDocument($thumbnail);
        }

        $media->legislationDocument->legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'menghapus dokumen ' . $documentType,
        ]);

        $media->delete();

        $request->session()->flash('message', '<strong>Berhasil!</strong> Data Dokumen telah berhasil dihapus');
    }
}
