<?php

namespace Database\Seeders;

use App\Enums\LawRelationshipStatus;
use App\Enums\LegislationRelationshipType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Legislation;
use App\Models\LegislationRelationship;

class LegislationRelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $typeOpt = LegislationRelationshipType::values();
        $status = LawRelationshipStatus::values();

        $laws = Legislation::ofType(1)->with(['category', 'user'])->get();

        foreach ($laws as $law) {
            if (rand(0, 1)) {
                for ($i=0; $i < rand(1, 3); $i++) {
                    $type = $typeOpt[rand(0, 2)];

                    if ($type == LegislationRelationshipType::STATUS->value) {
                        $relatedTo = Legislation::ofType(1)
                            ->whereNot('id', $law->id)
                            ->get()
                            ->random();

                        // Check if the relationship doesn't exist
                        if (LegislationRelationship::where('legislation_id', $law->id)
                            ->where('related_to', $relatedTo->id)
                            ->where('type', LegislationRelationshipType::STATUS)->doesntExist())
                            {
                                LegislationRelationship::create([
                                    'legislation_id'=> $law->id,
                                    'related_to'    => $relatedTo->id,
                                    'type'          => LegislationRelationshipType::STATUS,
                                    'status'        => $law->status == 'berlaku' ? fake()->randomElement([$status[0], $status[1], $status[3]]) : $status[2],
                                    'note'          => fake()->sentence(rand(3, 10)),
                                ]);
                            }
                    } else if ($type == LegislationRelationshipType::LEGISLATION->value) {
                        $relatedTo = Legislation::ofType(1)
                            ->whereNot('id', $law->id)
                            ->get()
                            ->random();

                        // Check if the relationship doesn't exist
                        if (LegislationRelationship::where('legislation_id', $law->id)
                            ->where('related_to', $relatedTo->id)
                            ->where('type', LegislationRelationshipType::LEGISLATION)->doesntExist())
                            {
                                LegislationRelationship::create([
                                    'legislation_id'=> $law->id,
                                    'related_to'    => $relatedTo->id,
                                    'type'          => LegislationRelationshipType::LEGISLATION,
                                    'status'        => $status[4],
                                    'note'          => fake()->sentence(rand(3, 10)),
                                ]);
                            }
                    } else if ($type == LegislationRelationshipType::DOCUMENT->value) {
                        $relatedTo = Legislation::ofType(2)
                            ->get()
                            ->random();

                        // Check if the relationship doesn't exist
                        if (LegislationRelationship::where('legislation_id', $law->id)
                            ->where('related_to', $relatedTo->id)
                            ->where('type', LegislationRelationshipType::DOCUMENT)->doesntExist())
                            {
                                LegislationRelationship::create([
                                    'legislation_id'=> $law->id,
                                    'related_to'    => $relatedTo->id,
                                    'type'          => LegislationRelationshipType::DOCUMENT,
                                    'status'        => null,
                                    'note'          => fake()->sentence(rand(3, 10)),
                                ]);
                            }
                    }
                }
            }
        }
    }
}
