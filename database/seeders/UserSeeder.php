<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a default user
        User::factory()
            ->create([
                'name'  => 'Harris Sontanu',
                'role'  => 'administrator',
                'default'   => 1,
            ]);

        User::factory()->count(5)->create();
    }
}
