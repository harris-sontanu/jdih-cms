<?php

namespace Database\Seeders;

use App\Models\Slide;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Slide::factory()
            ->has(Media::factory([
                'is_image'  => 0
            ]))
            ->count(4)
            ->create();
    }
}
