<?php

namespace Database\Factories;

use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'type_id'   => Type::all()->random(),
            'name'      => Str::title($name),
            'slug'      => Str::slug($name),
            'abbrev'    => Str::upper(fake()->unique()->word()),
            'code'      => rand(0, 1) ? fake()->unique()->word() : null,
            'desc'      => fake()->paragraph(rand(1, 3)),
            'user_id'   => User::where('role', 'administrator')->get()->random()
        ];
    }
}
