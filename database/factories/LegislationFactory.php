<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
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
        $approved = Carbon::parse($dt);
        $published = rand(0, 1) ? Carbon::parse($approved)->addDays(rand(1, 3)) : $approved;
        $created_at = rand(0, 1) ? Carbon::parse($published)->addDays(rand(1, 3)) : $published;
        $updated_at = rand(0, 1) ? Carbon::parse($created_at)->addDays(rand(1, 3)) : $created_at;
        $published_at = rand(0, 1) ? Carbon::parse($updated_at)->addDays(rand(1, 10)) : null;
        $deleted_at = empty($published_at) ? (rand(0, 1) ? Carbon::parse($updated_at)->addDays(rand(1, 3)) : null) : null;

        for ($i=0; $i < 3; $i++) {
            $signers[] = fake()->name();
        }

        return [
            'category_id'   => $category->id,
            'title'         => Str::title($title),
            'slug'          => Str::slug($title),
            'code_number'   => $number,
            'number'        => $number,
            'year'          => Carbon::parse($dt)->year,
            'call_number'   => $category->type_id == 2 ? fake()->bothify('### ??? ?.') : null,
            'edition'       => $category->type_id == 2 ? 'Cet. ' . fake()->randomDigitNotNull() : null,
            'place'         => fake()->words(rand(1, 2), true),
            'location'      => fake()->words(rand(1, 4), true),
            'approved'      => $approved->toDateString(),
            'published'     => $published->toDateString(),
            'publisher'     => $category->type_id == 2 ? fake()->words(rand(2, 4), true) : null,
            'source'        => $category->type_id == 2 ? null : fake()->words(rand(2, 4), true),
            'subject'       => fake()->sentence(),
            'status'        => $category->type_id == 1 ? (rand(0, 1) ? 'berlaku' : 'tidak berlaku') : ($category->type_id == 4 ? 'tetap' : null),
            'language'      => 'Indonesia',
            'author'        => fake()->words(rand(2, 4), true),
            'signer'        => $signers[rand(0, 2)],
            'note'          => rand(0, 1) ? fake()->sentence(rand(5, 10)) : null,
            'desc'          => $category->type_id == 2 ? fake()->randomNumber(3) . ' HLM. ; ' . fake()->randomNumber(2, true) . 'CM' : null,
            'isbn'          => $category->type_id == 2 ? fake()->randomNumber(9, true) : null,
            'index_number'  => fake()->randomDigitNotNull(),
            'justice'       => $category->type_id == 4 ? fake()->words(2, 4) : null,
            'view'          => fake()->randomDigitNotNull() * 10,
            'user_id'       => User::all()->random(),
            'created_at'    => $created_at->toDateTimeString(),
            'updated_at'    => $updated_at->toDateTimeString(),
            'published_at'  => isset($published_at) ? $published_at->toDateTimeString() : null,
            'deleted_at'    => isset($deleted_at) ? $deleted_at->toDateTimeString() : null,
        ];
    }
}
