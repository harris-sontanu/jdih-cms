<?php

namespace Database\Seeders;

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
        $typeOpt = ['status', 'legislation', 'document'];
        $status = ['mengubah', 'diubah', 'mencabut', 'dicabut'];

        $laws = Legislation::with(['category' => function ($query) {
            $query->where('type_id', 1);
        }])->get();

        foreach ($laws as $law) {
            if (rand(0, 1)) {
                for ($i=0; $i < rand(1, 3); $i++) {
                    $type = $typeOpt[rand(0, 2)];

                    if ($type == 'status') {
                        $relatedTo = Legislation::with(['category' => function ($query) {
                                $query->where('type_id', 1);
                            }])->whereNot('id', $law->id)
                            ->get()
                            ->random();

                        // Check if the relationship doesn't exist
                        if (LegislationRelationship::where('legislation_id', $law->id)
                            ->where('related_to', $relatedTo->id)
                            ->where('type', 'status')->doesntExist())
                            {
                                LegislationRelationship::create([
                                    'legislation_id'=> $law->id,
                                    'related_to'    => $relatedTo->id,
                                    'type'          => 'status',
                                    'status'        => $law->status == 'berlaku' ? $status[rand(0, 2)] : $status[3],
                                    'note'          => fake()->sentence(rand(3, 10)),
                                ]);
                            }
                    } else if ($type == 'legislation') {
                        $relatedTo = Legislation::with(['category' => function ($query) {
                                $query->where('type_id', 1);
                            }])->whereNot('id', $law->id)
                            ->get()
                            ->random();

                        // Check if the relationship doesn't exist
                        if (LegislationRelationship::where('legislation_id', $law->id)
                            ->where('related_to', $relatedTo->id)
                            ->where('type', 'legislation')->doesntExist())
                            {
                                LegislationRelationship::create([
                                    'legislation_id'=> $law->id,
                                    'related_to'    => $relatedTo->id,
                                    'type'          => 'legislation',
                                    'status'        => 'melaksanakan',
                                    'note'          => fake()->sentence(rand(3, 10)),
                                ]);
                            }
                    } else if ($type == 'document') {
                        $relatedTo = Legislation::with(['category' => function ($query) {
                                $query->where('type_id', 2);
                            }])
                            ->get()
                            ->random();

                        // Check if the relationship doesn't exist
                        if (LegislationRelationship::where('legislation_id', $law->id)
                            ->where('related_to', $relatedTo->id)
                            ->where('type', 'document')->doesntExist())
                            {
                                LegislationRelationship::create([
                                    'legislation_id'=> $law->id,
                                    'related_to'    => $relatedTo->id,
                                    'type'          => 'document',
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
