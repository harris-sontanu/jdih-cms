<?php

namespace App\Http\Controllers\Admin\Legislation;

use App\Enums\LegislationDocumentType;
use App\Http\Controllers\Admin\Legislation\LegislationController;
use Illuminate\Http\Request;
use App\Models\Media;

class DocumentController extends LegislationController
{
    public function __invoke($id, Request $request)
    {
        $media = Media::findOrFail($id);

        $this->removeMedia($media->path);

        if ($media->mediaable->type === LegislationDocumentType::MASTER) {
            $documentType = 'Batang Tubuh';
        } else if ($media->mediaable->type === LegislationDocumentType::ABSTRACT) {
            $documentType = 'Abstrak';
        } else if ($media->mediaable->type === LegislationDocumentType::ATTACHMENT) {
            $documentType = 'Lampiran';
        } else if ($media->mediaable->type === LegislationDocumentType::COVER) {
            $documentType = 'Sampul';
        }

        $media->mediaable->legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'menghapus dokumen ' . $documentType,
        ]);

        $media->mediaable->delete();
        $media->delete();

        $request->session()->flash('message', '<strong>Berhasil!</strong> Data Dokumen telah berhasil dihapus');
    }
}
