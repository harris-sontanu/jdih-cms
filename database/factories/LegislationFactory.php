<?php

namespace Database\Factories;

use App\Models\Category;
use Carbon\Carbon;
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
        $category = Category::all()->random();
        $title = fake()->unique()->sentence(rand(6, 12));
        $number = fake()->randomNumber(rand(1, 4));

        $dt = fake()->dateTimeBetween('-5 years', '+3 weeks');

        return [
            'category_id'   => $category->id,
            'title'         => Str::title($title),
            'slug'          => Str::slug($title),
            'code_number'   => $number,
            'number'        => $number,
            'year'          => Carbon::parse($dt)->year,


        ];
    }
}
