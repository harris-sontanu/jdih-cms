<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Media;
use App\Models\Taxonomy;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = fake()->unique()->sentence(rand(5, 12));
        $slug  = Str::slug($title);
        $paragraphs  = fake()->paragraphs(rand(3, 6));
        $body  = '<p>';
        $body  .= implode('</p><p>', $paragraphs);
        $body  .= '</p>';

        $dt = fake()->dateTimeBetween('-5 years', '+3 weeks');
        $created_at = rand(0, 1) ? Carbon::parse($dt)->addDays(rand(1, 3)) : Carbon::parse($dt);
        $updated_at = rand(0, 1) ? Carbon::parse($created_at)->addDays(rand(1, 3)) : $created_at;
        $published_at = rand(0, 1) ? Carbon::parse($updated_at)->addDays(rand(1, 10)) : null;
        $deleted_at = empty($published_at) ? (rand(0, 1) ? Carbon::parse($updated_at)->addDays(rand(1, 3)) : null) : null;

        return [
            'taxonomy_id'   => Taxonomy::ofType('news')->get()->random(),
            'title'         => $title,
            'slug'          => $slug,
            'excerpt'       => fake()->paragraph(),
            'body'          => $body,
            'source'        => fake()->words(rand(1, 3), true),
            'view'          => fake()->randomDigitNotNull() * 10,
            'author_id'     => Employee::all()->random(),
            'user_id'       => User::all()->random(),
            'created_at'    => $created_at->toDateTimeString(),
            'updated_at'    => $updated_at->toDateTimeString(),
            'published_at'  => isset($published_at) ? $published_at->toDateTimeString() : null,
            'deleted_at'    => isset($deleted_at) ? $deleted_at->toDateTimeString() : null,
        ];
    }
}
