<?php

namespace Database\Seeders;

use App\Models\Legislation;
use App\Models\LegislationDocument;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LegislationDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $legislations = Legislation::all();
        foreach ($legislations as $legislation)
        {
            if ($legislation->category->type_id === 1) {

                $media = $this->createMedia();

                LegislationDocument::factory()->create([
                    'legislation_id'    => $legislation->id,
                    'media_id'  => $media->id,
                    'type'  => 'master'
                ]);

                if (rand(0, 1)) {

                    $media = $this->createMedia();

                    LegislationDocument::factory()->create([
                        'legislation_id'    => $legislation->id,
                        'media_id'  => $media->id,
                        'type'  => 'abstract'
                    ]);
                }
            }
        }
    }

    protected function createMedia()
    {
        $fileName = rand(1, 10) . '.pdf';
        $publicPath = public_path('assets/admin/demo/document/' . $fileName);
        $storageDir = 'demo/documents/';
        Storage::disk('public')->makeDirectory($storageDir);
        $storagePath = storage_path('app/public/' . $storageDir . $fileName);

        File::copy($publicPath, $storagePath);

        $media = Media::factory()->create([
            'file_name' => $fileName,
            'mime_type' => 'application/pdf',
            'is_image'  => 0,
            'path'      => $storageDir . $fileName,
        ]);

        return $media;
    }
}
