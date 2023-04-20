<?php

namespace Database\Seeders;

use App\Enums\LegislationDocumentType;
use App\Enums\UserRole;
use App\Models\Legislation;
use App\Models\LegislationDocument;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
                    'type'  => LegislationDocumentType::MASTER
                ]);

                $this->createMedia($master);

                if (rand(0, 1)) {

                    $abstract = LegislationDocument::create([
                        'legislation_id'    => $legislation->id,
                        'type'  => LegislationDocumentType::ABSTRACT
                    ]);

                    $this->createMedia($abstract);
                }

            } else if ($legislation->category->type_id === 2) {

                $cover = LegislationDocument::create([
                    'legislation_id'    => $legislation->id,
                    'type'  => LegislationDocumentType::COVER
                ]);

                $this->createMedia($cover);
            }
        }
    }

    protected function createMedia($media)
    {
        if ($media->type == LegislationDocumentType::COVER) {
            $fileName = 'book' . rand(1, 6) . '.jpg';
            $publicPath = public_path('assets/jdih/images/demo/' . $fileName);
        } else {
            $fileName = rand(1, 10) . '.pdf';
            $publicPath = public_path('assets/admin/demo/document/' . $fileName);
        }
        $storageDir = 'produk-hukum/' . $media->legislation->category->type->slug . '/' . $media->legislation->year . '/' . Str::lower($media->legislation->category->slug) . '/';
        Storage::disk('public')->makeDirectory($storageDir);
        $storagePath = storage_path('app/public/' . $storageDir . $fileName);

        File::copy($publicPath, $storagePath);
        if ($media->type == LegislationDocumentType::COVER) {
            $fileThumbName = Str::replace(".jpg", "_md.jpg", $fileName);
            $storageThumbPath = storage_path('app/public/' . $storageDir . $fileThumbName);
            File::copy($publicPath, $storageThumbPath);
        }

        $media->media()->create([
            'name'      => fake()->words(rand(1, 3), true),
            'file_name' => $fileName,
            'mime_type' => 'application/pdf',
            'is_image'  => 0,
            'path'      => $storageDir . $fileName,
            'caption'   => fake()->sentence(rand(4, 7)),
            'user_id'   => User::whereIn('role', [UserRole::ADMIN, UserRole::EDITOR, UserRole::AUTHOR])->get()->random()->value('id'),
        ]);
    }
}
