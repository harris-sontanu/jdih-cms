<?php

namespace Database\Factories;

use App\Enums\TaxonomyType;
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
        $types = [TaxonomyType::PAGE->name, TaxonomyType::NEWS->name, TaxonomyType::EMPLOYEE->name];
        $name = fake()->unique()->words(1, true);

        return [
            'type'      => fake()->randomElement($types),
            'name'      => Str::title($name),
            'slug'      => Str::slug($name),
            'desc'      => fake()->paragraph(rand(1, 3))
        ];
    }
}
