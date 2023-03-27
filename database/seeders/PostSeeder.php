<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory()
            ->create([
                'taxonomy_id'   => 1,
                'title'         => 'Visi & Misi',
                'slug'          => 'visi-misi',
                'source'        => null,
            ]);

        Post::factory()
            ->create([
                'taxonomy_id'   => 1,
                'title'         => 'Tugas Pokok & Fungsi',
                'slug'          => 'tugas-pokok-fungsi',
                'source'        => null,
            ]);

        Post::factory()
            ->create([
                'taxonomy_id'   => 1,
                'title'         => 'Struktur Organisasi',
                'slug'          => 'struktur-organisasi',
                'source'        => null,
            ]);

        $posts = Post::factory()
            ->count(20)
            ->hasCover()
            ->create();

        $posts->each(function ($post, $key) {
            $cover_id = $post->cover->id;
            $post->update([
                'cover_id'  => $cover_id
            ]);
        });
    }
}
