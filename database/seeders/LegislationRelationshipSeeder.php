<?php

namespace Database\Seeders;

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
        $status = ['mengubah', 'diubah', 'mencabut', 'dicabut'];

        $laws = Legislation::with(['category' => function ($query) {
            $query->where('type_id', 1);
        }])->get();

        foreach ($laws as $law) {
            if (rand(0, 1)) {
                for ($i=0; $i < rand(1, 3); $i++) {
                    $type = $typeOpt[rand(0, 2)];

                    if ($type == LegislationRelationshipType::STATUS->name) {
                        $relatedTo = Legislation::with(['category' => function ($query) {
                                $query->where('type_id', 1);
                            }])->whereNot('id', $law->id)
                            ->get()
                            ->random();

                        // Check if the relationship doesn't exist
                        if (LegislationRelationship::where('legislation_id', $law->id)
                            ->where('related_to', $relatedTo->id)
                            ->where('type', LegislationRelationshipType::STATUS->name)->doesntExist())
                            {
                                LegislationRelationship::create([
                                    'legislation_id'=> $law->id,
                                    'related_to'    => $relatedTo->id,
                                    'type'          => LegislationRelationshipType::STATUS->name,
                                    'status'        => $law->status == 'berlaku' ? $status[rand(0, 2)] : $status[3],
                                    'note'          => fake()->sentence(rand(3, 10)),
                                ]);
                            }
                    } else if ($type == LegislationRelationshipType::LEGISLATION->name) {
                        $relatedTo = Legislation::with(['category' => function ($query) {
                                $query->where('type_id', 1);
                            }])->whereNot('id', $law->id)
                            ->get()
                            ->random();

                        // Check if the relationship doesn't exist
                        if (LegislationRelationship::where('legislation_id', $law->id)
                            ->where('related_to', $relatedTo->id)
                            ->where('type', LegislationRelationshipType::LEGISLATION->name)->doesntExist())
                            {
                                LegislationRelationship::create([
                                    'legislation_id'=> $law->id,
                                    'related_to'    => $relatedTo->id,
                                    'type'          => LegislationRelationshipType::LEGISLATION->name,
                                    'status'        => 'melaksanakan',
                                    'note'          => fake()->sentence(rand(3, 10)),
                                ]);
                            }
                    } else if ($type == LegislationRelationshipType::DOCUMENT->name) {
                        $relatedTo = Legislation::with(['category' => function ($query) {
                                $query->where('type_id', 2);
                            }])
                            ->get()
                            ->random();

                        // Check if the relationship doesn't exist
                        if (LegislationRelationship::where('legislation_id', $law->id)
                            ->where('related_to', $relatedTo->id)
                            ->where('type', LegislationRelationshipType::DOCUMENT->name)->doesntExist())
                            {
                                LegislationRelationship::create([
                                    'legislation_id'=> $law->id,
                                    'related_to'    => $relatedTo->id,
                                    'type'          => LegislationRelationshipType::DOCUMENT->name,
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
