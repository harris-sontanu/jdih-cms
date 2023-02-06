<?php

namespace Database\Seeders;

use App\Models\Legislation;
use App\Models\LegislationDocument;
use App\Models\User;
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

                $master = LegislationDocument::create([
                    'legislation_id'    => $legislation->id,
                    'type'  => 'master'
                ]);

                $this->createMedia($master);

                if (rand(0, 1)) {

                    $abstract = LegislationDocument::create([
                        'legislation_id'    => $legislation->id,
                        'type'  => 'abstract'
                    ]);

                    $this->createMedia($abstract);
                }
            }
        }
    }

    protected function createMedia($media)
    {
        $fileName = rand(1, 10) . '.pdf';
        $publicPath = public_path('assets/admin/demo/document/' . $fileName);
        $storageDir = 'demo/documents/';
        Storage::disk('public')->makeDirectory($storageDir);
        $storagePath = storage_path('app/public/' . $storageDir . $fileName);

        File::copy($publicPath, $storagePath);

        $media->media()->create([
            'name'      => fake()->words(rand(1, 3), true),
            'file_name' => $fileName,
            'mime_type' => 'application/pdf',
            'is_image'  => 0,
            'path'      => $storageDir . $fileName,
            'caption'   => fake()->sentence(rand(4, 7)),
            'user_id'   => User::all()->random()
        ]);
    }
}
