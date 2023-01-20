<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Legislation>
 */
class LegislationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = fake()->unique()->sentence(rand(6, 12));
        return [
            'category_id'   => Category::where('type_id', 1)->get()->random(),
            'title'         => Str::title($title),
            'slug'          => Str::slug($title),
        ];
    }
}
