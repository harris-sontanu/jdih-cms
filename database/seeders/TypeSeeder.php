<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name'  => 'peraturan perundang-undangan',
                'slug'  => 'peraturan-perundang-undangan',
                'sort'  => 1,
                'route' => 'law',
            ],
            [
                'name'  => 'monografi hukum',
                'slug'  => 'monografi-hukum',
                'sort'  => 2,
                'route' => 'monograph',
            ],
            [
                'name'  => 'artikel hukum',
                'slug'  => 'artikel-hukum',
                'sort'  => 3,
                'route' => 'article',
            ],
            [
                'name'  => 'putusan pengadilan',
                'slug'  => 'putusan-pengadilan',
                'sort'  => 4,
                'route' => 'judgment',
            ],
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
