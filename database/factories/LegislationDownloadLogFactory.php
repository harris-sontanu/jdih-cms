<?php

namespace Database\Factories;

use App\Models\LegislationDocument;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LegislationDownloadLog>
 */
class LegislationDownloadLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dt = fake()->dateTimeBetween('-2 weeks');
        $created_at = Carbon::parse($dt);

        return [
            'ipv4'  => fake()->ipv4(),
            'legislation_document_id'   => LegislationDocument::all()->random(),
            'created_at'    => $created_at->toDateTimeString(),
        ];
    }
}
