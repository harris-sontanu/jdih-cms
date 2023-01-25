<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $types = ['identity', 'question'];
        return [
            'title' => fake()->words(rand(2, 7), true) . '?',
            'type'  => $types[rand(0, 1)],
        ];
    }
}
