<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Institute>
 */
class InstituteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->unique()->words(rand(1, 3), true);
        return [
            'name'      => Str::title($name),
            'slug'      => Str::slug($name),
            'abbrev'    => fake()->unique()->word(),
            'desc'      => fake()->paragraph(rand(1, 3))
        ];
    }
}
