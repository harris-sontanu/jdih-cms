<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slide>
 */
class SlideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'header'    => fake()->sentence(rand(2, 5)),
            'subheader' => fake()->sentence(rand(6, 12)),
            'desc'      => fake()->text(),
        ];
    }
}
