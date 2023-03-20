<?php

namespace Database\Seeders;

use App\Models\Navigation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $navigations = [
            [
                'name'  => 'Beranda',
                'slug'  => 'beranda',
                'url'   => '/',
            ],
            [
                'name'  => 'Produk Hukum',
                'slug'  => 'produk-hukum',
                'url'   => '/produk-hukum',
                ''
            ]
        ];

        foreach ($navigations as $nav) {
            Navigation::create($nav);
        }
    }
}
