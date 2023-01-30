<?php

namespace Database\Factories;

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
    public function definition()
    {
        $types = ['master', 'abstract', 'attachment', 'cover'];
        return [
            'legislation_id'    => Legislation::all()->random(),
            // 'media_id'          => Media::factory()->create(),
            'type'              => $types[rand(0, 3)],
            'download'          => rand(1, 10) * rand(1, 10),
        ];
    }
}
