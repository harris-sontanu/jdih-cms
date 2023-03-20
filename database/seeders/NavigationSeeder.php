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
            ],
            [
                'name'  => 'Peraturan Perundang-undangan',
                'slug'  => 'peraturan-perundang-undangan',
                'url'   => '/produk-hukum/peraturan-perundang-undangan',
                'parent'=> 2,
            ],
            [
                'name'  => 'Monografi Hukum',
                'slug'  => 'monografi-hukum',
                'url'   => '/produk-hukum/monografi-hukum',
                'parent'=> 2,
            ],
            [
                'name'  => 'Artikel Hukum',
                'slug'  => 'artikel-hukum',
                'url'   => '/produk-hukum/artikel-hukum',
                'parent'=> 2,
            ],
            [
                'name'  => 'Putusan Pengadilan',
                'slug'  => 'putusan-pengadilan',
                'url'   => '/produk-hukum/putusan-pengadilan',
                'parent'=> 2,
            ],
            [
                'name'  => 'Berita',
                'slug'  => 'berita',
                'url'   => '/berita'
            ],
            [
                'name'  => 'Profil',
                'slug'  => 'profil',
                'url'   => '/profil',
            ],
            [
                'name'  => 'Visi & Misi',
                'slug'  => 'visi-misi',
                'url'   => '/profil/visi-misi',
                'parent'=> 4,
            ],
            [
                'name'  => 'Tugas Pokok & Fungsi',
                'slug'  => 'tugas-pokok-fungsi',
                'url'   => '/profil/tugas-pokok-fungsi',
                'parent'=> 4,
            ],
            [
                'name'  => 'Struktur Organisasi',
                'slug'  => 'struktur-organisasi',
                'url'   => '/profil/struktur-organisasi',
                'parent'=> 4,
            ],
            [
                'name'  => 'Galeri',
                'slug'  => 'galeri',
                'url'   => '/galeri',
            ],
            [
                'name'  => 'Foto',
                'slug'  => 'foto',
                'url'   => 'galeri/foto',
                'parent'=> 5,
            ],
            [
                'name'  => 'Video',
                'slug'  => 'video',
                'url'   => 'galeri/video',
                'parent'=> 5
            ],
            [
                'name'  => 'Kontak',
                'slug'  => 'kontak',
                'url'   => '/kontak'
            ]
        ];

        foreach ($navigations as $nav) {
            Navigation::create($nav);
        }
    }
}
