<?php

namespace Database\Seeders;

use App\Models\Legislation;
use App\Models\LegislationLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LegislationLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $legislations = Legislation::all();

        $legislations->each(function($legislation, $key) {

            $type = match ($legislation->category->type_id) {
                1   => 'peraturan',
                2   => 'monografi',
                3   => 'artikel',
                4   => 'putusan',
            };

            LegislationLog::factory()->create([
                'legislation_id'    => $legislation->id,
                'message'           => 'menambahkan ' . $type,
                'created_at'        => $legislation->created_at,
            ]);
        });
    }
}
