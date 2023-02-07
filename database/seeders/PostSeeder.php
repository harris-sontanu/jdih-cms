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
