<?php

namespace Database\Factories;

use App\Enums\LegislationDocumentType;
use App\Models\Legislation;
use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LegislationDocument>
 */
class LegislationDocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'legislation_id'    => Legislation::all()->random(),
            'type'              => fake()->randomElement(LegislationDocumentType::names()),
            'download'          => rand(1, 10) * rand(1, 10),
        ];
    }
}
