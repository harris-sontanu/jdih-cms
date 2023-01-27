<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fileName = rand(1, 12) . '.jpg';
        $fileThumbName = Str::replace(".jpg", "_md.jpg", $fileName);

        // Move demo media file into public storage
        $publicPath = public_path('assets/admin/images/demo/blog/' . $fileName);

        $storageDir = 'posts/news/';
        Storage::disk('public')->makeDirectory($storageDir);
        $storagePath = storage_path('app/public/' . $storageDir . $fileName);
        $storageThumbPath = storage_path('app/public/' . $storageDir . $fileThumbName);

        File::copy($publicPath, $storagePath);
        File::copy($publicPath, $storageThumbPath);

        return [
            'name'      => fake()->words(rand(1, 3), true),
            'file_name' => rand(1, 12) . '.jpg',
            'mime_type' => 'image/jpeg',
            'path'      => $storageDir . $fileName,
            'caption'   => fake()->sentence(rand(4, 7)),
            'is_image'  => 1,
            'user_id'   => User::all()->random()
        ];
    }
}
