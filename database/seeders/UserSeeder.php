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
        //
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Reviewer',
            'email' => 'reviewer@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'reviewer'
        ]);

        User::create([
            'name' => 'Speaker',
            'email' => 'speaker@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'speaker'
        ]);
    }
}
