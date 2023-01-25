<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Taxonomy>
 */
class TaxonomyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {   
        $types = ['news', 'page', 'employee'];
        $name = fake()->unique()->words(1, true);

        return [
            'type'      => $types[rand(0, 2)],
            'name'      => Str::title($name),
            'slug'      => Str::slug($name),
            'desc'      => fake()->paragraph(rand(1, 3))
        ];
    }
}
