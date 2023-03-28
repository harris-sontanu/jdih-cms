<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $links = Link::factory()
            ->count(8)
            ->create();

        $links->each(function ($link, $key) {
            if ($link->type == 'banner') {
                $fileName = 'banner' . rand(1, 5) . '.png';
                $storageDir = 'images/tautan/banner/';
                $this->createMedia($link->id, $storageDir, $fileName);
            } else if ($link->type == 'jdih') {
                $fileName = 'jdih' . rand(1, 9) . '.png';
                $storageDir = 'images/tautan/jdih/';
                $this->createMedia($link->id, $storageDir, $fileName);
            }
        });
    }

    private function createMedia($id, $storageDir, $fileName)
    {
        $fileThumbName = Str::replace(".png", "_md.png", $fileName);
        $publicPath = public_path('assets/jdih/images/demo/' . $fileName);

        Storage::disk('public')->makeDirectory($storageDir);
        $storagePath = storage_path('app/public/' . $storageDir . $fileName);
        $storageThumbPath = storage_path('app/public/' . $storageDir . $fileThumbName);

        File::copy($publicPath, $storagePath);
        File::copy($publicPath, $storageThumbPath);

        Media::factory([
            'file_name' => $fileName,
            'is_image'  => 0,
            'path'      => $storageDir . $fileName,
            'mediaable_id'  => $id,
            'mediaable_type'=> 'App\Models\Link',
        ])->create();
    }
}
