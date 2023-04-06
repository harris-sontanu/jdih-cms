<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $page = Post::factory()
            ->create([
                'taxonomy_id'   => 1,
                'title'         => 'Visi & Misi',
                'slug'          => 'visi-misi',
                'source'        => null,
            ]);

        $this->createCover($page, 'halaman/', '3.jpg', 'assets/jdih/images/illustrations/');

        $page = Post::factory()
            ->create([
                'taxonomy_id'   => 1,
                'title'         => 'Tugas Pokok & Fungsi',
                'slug'          => 'tugas-pokok-fungsi',
                'source'        => null,
            ]);

        $this->createCover($page, 'halaman/', '2.jpg', 'assets/jdih/images/illustrations/');

        $page = Post::factory()
            ->create([
                'taxonomy_id'   => 1,
                'title'         => 'Struktur Organisasi',
                'slug'          => 'struktur-organisasi',
                'source'        => null,
            ]);

        $this->createCover($page, 'halaman/', '4.jpg', 'assets/jdih/images/illustrations/');

        $page = Post::factory()
            ->create([
                'taxonomy_id'   => 1,
                'title'         => 'Kontak',
                'slug'          => 'kontak',
                'source'        => null,
            ]);

        $this->createCover($page, 'halaman/', '7.jpg', 'assets/jdih/images/illustrations/');

        $page = Post::factory()
            ->create([
                'taxonomy_id'   => 1,
                'title'         => 'Privasi',
                'slug'          => 'privasi',
                'source'        => null,
            ]);

        $this->createCover($page, 'halaman/', '8.jpg', 'assets/jdih/images/illustrations/');

        $page = Post::factory()
            ->create([
                'taxonomy_id'   => 1,
                'title'         => 'Syarat dan Ketentuan',
                'slug'          => 'syarat-dan-ketentuan',
                'source'        => null,
            ]);

        $this->createCover($page, 'halaman/', '6.jpg', 'assets/jdih/images/illustrations/');

        $posts = Post::factory()
            ->count(20)
            ->create();

        $posts->each(function ($post, $key) {

            $fileName = rand(1, 12) . '.jpg';
            $storageDir = 'berita/' . $post->timeFormatted($post->created_at, 'Y') . '/';

            $media = $this->createCover($post, $storageDir, $fileName, 'assets/admin/images/demo/blog/');

            $post->update([
                'cover_id'  => $media->id
            ]);
        });
    }

    protected function createCover($post, $storageDir, $fileName, $publicDir)
    {
        $fileThumbName = Str::replace(".jpg", "_md.jpg", $fileName);
        $publicPath = public_path($publicDir . $fileName);

        Storage::disk('public')->makeDirectory($storageDir);
        $storagePath = storage_path('app/public/' . $storageDir . $fileName);
        $storageThumbPath = storage_path('app/public/' . $storageDir . $fileThumbName);

        File::copy($publicPath, $storagePath);
        File::copy($publicPath, $storageThumbPath);

        $media = $post->cover()->create([
            'name'      => fake()->words(rand(1, 3), true),
            'file_name' => $fileName,
            'mime_type' => 'image/jpeg',
            'is_image'  => 0,
            'path'      => $storageDir . $fileName,
            'caption'   => fake()->sentence(rand(4, 7)),
            'is_image'  => 1,
            'user_id'   => $post->user_id,
        ]);

        return $media;
    }
}
