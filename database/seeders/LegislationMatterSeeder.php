<?php

namespace Database\Seeders;

use App\Models\Legislation;
use App\Models\Matter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LegislationMatterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $laws = Legislation::with(['category' => function ($query) {
            $query->where('type_id', 1);
        }])->get();

        foreach ($laws as $law) {
            if (rand(0, 1)) {
                $sync = [];
                for ($i=0; $i < rand(1, 5); $i++) { 
                    $matter = Matter::all()->random();
                    $sync[] = $matter->id;
                }
                $law->matters()->sync($sync);
            }
        }
    }
}
