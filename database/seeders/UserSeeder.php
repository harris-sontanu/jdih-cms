<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default user
        User::factory()
            ->create([
                'name'  => 'Harris Sontanu',
                'username'  => 'admin',
                'email' => 'harris.sontanu@gmail.com',
                'role'  => UserRoleEnum::ADMIN,
            ]);

        User::factory()->count(15)->create();
    }
}
