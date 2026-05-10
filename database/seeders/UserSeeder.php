<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Account
        $admin = User::create([
            'name' => 'PCAR Administrator',
            'email' => 'admin@pcar.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // Editor Account
        $editor = User::create([
            'name' => 'Data Curator',
            'email' => 'editor@pcar.com',
            'password' => Hash::make('password'),
        ]);
        $editor->assignRole('editor');

        // Normal User Account
        $user = User::create([
            'name' => 'Car Enthusiast',
            'email' => 'user@pcar.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('user');
    }
}
