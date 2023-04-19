<?php

namespace Database\Seeders;

use App\Models\Slide;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $slides = Slide::factory()
            ->count(4)
            ->create();

        $slides->each(function ($slide, $key) {

            $fileName = 'slide' . $key + 1 . '.jpg';
            $fileThumbName = Str::replace(".jpg", "_md.jpg", $fileName);

            // Move demo media file into public storage
            $publicPath = public_path('assets/jdih/images/demo/' . $fileName);

            $storageDir = 'images/slide/';
            Storage::disk('public')->makeDirectory($storageDir);
            $storagePath = storage_path('app/public/' . $storageDir . $fileName);
            $storageThumbPath = storage_path('app/public/' . $storageDir . $fileThumbName);

            File::copy($publicPath, $storagePath);
            File::copy($publicPath, $storageThumbPath);

            Media::factory([
                'file_name' => $fileName,
                'is_image'  => 0,
                'path'      => $storageDir . $fileName,
                'mediaable_id'  => $slide->id,
                'mediaable_type'=> 'App\Models\Slide',
            ])->create();
        });
    }
}
