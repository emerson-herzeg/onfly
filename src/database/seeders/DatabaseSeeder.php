<?php

namespace Database\Seeders;

use App\Models\UserModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        UserModel::factory()->create([
            'name' => 'Test User 1',
            'email' => 'test1@test.com',
            'password' =>  Hash::make('password1'),
        ]);

        UserModel::factory()->create([
            'name' => 'Test User 2',
            'email' => 'test2@test.com',
            'password' =>  Hash::make('password2'),
        ]);
    }
}
