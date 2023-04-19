<?php

namespace Database\Factories;

use App\Enums\UserRole;
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
    public function definition(): array
    {
        return [
            'name'      => fake()->words(rand(1, 3), true),
            'file_name' => rand(1, 12) . '.jpg',
            'mime_type' => 'image/jpeg',
            'caption'   => fake()->sentence(rand(4, 7)),
            'is_image'  => 1,
            'user_id'   => User::whereIn('role', [UserRole::ADMIN, UserRole::EDITOR, UserRole::AUTHOR])->get()->random()
        ];
    }
}
