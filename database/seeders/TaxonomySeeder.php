<?php

namespace Database\Seeders;

use App\Enums\TaxonomyType;
use App\Models\Taxonomy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxonomySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create one type of page taxonomy
        Taxonomy::factory()->create([
            'type'  => TaxonomyType::PAGE,
            'name'  => 'Page',
            'slug'  => 'page',
            'desc'  => null
        ]);

        Taxonomy::factory()->create([
            'type'  => TaxonomyType::EMPLOYEE,
            'name'  => 'Pengelola JDIH',
            'slug'  => 'pengelola-jdih',
            'desc'  => null
        ]);

        Taxonomy::factory()->count(18)->create();
    }
}
