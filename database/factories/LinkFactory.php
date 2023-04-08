<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $types = ['banner', 'jdih', 'youtube'];
        $type  = $types[rand(0, 2)];
        $displays = ['main', 'aside', 'popup'];

        $youtubeUrls = ['https://youtu.be/dGO3_oznSB0', 'https://youtu.be/lcQ1dH6GL7k', 'https://youtu.be/CFUbfuIGYls'];

        $dt = fake()->dateTimeBetween('-3 years', '+3 weeks');
        $created_at = rand(0, 1) ? Carbon::parse($dt)->addDays(rand(1, 3)) : Carbon::parse($dt);
        $updated_at = rand(0, 1) ? Carbon::parse($created_at)->addDays(rand(1, 3)) : $created_at;
        $published_at = Carbon::parse($updated_at)->addDays(rand(1, 10));

        return [
            'title'     => fake()->sentence(rand(6, 12)),
            'desc'      => fake()->paragraph(rand(1, 2)),
            'url'       => $type == 'youtube' ? $youtubeUrls[rand(0, 2)] : fake()->url(),
            'type'      => $type,
            'display'   => $type == 'banner' ? $displays[rand(0, 1)] : null,
            'user_id'   => User::all()->random(),
            'created_at'    => $created_at->toDateTimeString(),
            'updated_at'    => $updated_at->toDateTimeString(),
            'published_at'  => $published_at->toDateTimeString(),
        ];
    }
}
