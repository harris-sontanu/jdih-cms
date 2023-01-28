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

        if ($media->legislationDocuments->type === 'master') {
            $documentType = 'Batang Tubuh';
        } else if ($media->legislationDocuments->type === 'abstract') {
            $documentType = 'Abstrak';
        } else if ($media->legislationDocuments->type === 'attachment') {
            $documentType = 'Lampiran';
        } else if ($media->legislationDocuments->type === 'cover') {
            $documentType = 'Sampul';

            // Remove thumbnail
            $ext        = substr(strrchr($media->legislationDocuments->path, '.'), 1);
            $thumbnail  = str_replace(".{$ext}", "_thumb.{$ext}", $media->legislationDocuments->path);
            $this->removeDocument($thumbnail);
        }
        $media->legislationDocuments->legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'menghapus dokumen ' . $documentType,
        ]);

        $media->delete();

        $request->session()->flash('message', '<strong>Berhasil!</strong> Data Dokumen telah berhasil dihapus');
    }
}
