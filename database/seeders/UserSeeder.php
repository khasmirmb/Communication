<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 123, // Change 'password' to a secure password
            'type' => '1',
        ]);

        User::create([
            'name' => 'USER NUM 1',
            'email' => 'user1@gmail.com',
            'password' => 123, // Change 'password' to a secure password
            'type' => '0',
        ]);

        User::create([
            'name' => 'USER NUM 2',
            'email' => 'user2@gmail.com',
            'password' => 123, // Change 'password' to a secure password
            'type' => '0',
        ]);
    }
}
