<?php

namespace Database\Seeders;

use App\Models\Legislation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LegislationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Legislation::factory()->count(120)->create();
    }
}
