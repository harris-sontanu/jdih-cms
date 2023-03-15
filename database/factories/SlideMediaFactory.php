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
class SlideMediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fileName = 'slide' . rand(1, 4) . '.jpg';

        // Move demo media file into public storage
        $publicPath = public_path('assets/admin/images/demo/' . $fileName);

        $storageDir = 'images/slide/';
        Storage::disk('public')->makeDirectory($storageDir);
        $storagePath = storage_path('app/public/' . $storageDir . $fileName);

        File::copy($publicPath, $storagePath);

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
