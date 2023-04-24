<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visitor>
 */
class VisitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $dt = fake()->dateTimeBetween('-1 month');
        $created_at = Carbon::parse($dt);
        $updated_at = rand(0, 1) ? Carbon::parse($created_at)->addDays(rand(1, 3)) : $created_at;

        return [
            'ipv4'  => DB::raw('INET_ATON("'.fake()->ipv4().'")'),
            'hits'  => rand(1, 99),
            'page'  => '/',
            'browser'   => fake()->randomElement(['Chrome', 'Firefox', 'Safari', 'Opera', 'Edge']),
            'mobile'    => rand(0, 1),
            'platform'  => fake()->randomElement(['Windows', 'Linux', 'OS X']),
            'version'   => null,
            'robot'     => null,
            'created_at'    => $created_at->toDateTimeString(),
            'updated_at'    => $updated_at->toDateTimeString(),
        ];
    }
}
