<?php

namespace Database\Seeders;

use App\Models\Legislation;
use App\Models\LegislationDocument;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        foreach ($legislations as $legislation) {
            if ($legislation->category->type_id === 1) {
                $media = Media::factory()->create([
                    'file_name' => rand(1, 10) . '.pdf',
                    'mime_type' => 'application/pdf',
                    'is_image'  => 0,
                    'path'      => 'demo/documents/',
                ]);

                LegislationDocument::factory()->create([
                    'legislation_id'    => $legislation->id,
                    'media_id'  => $media->id,
                    'type'  => 'master'
                ]);
            }
        }
    }
}
