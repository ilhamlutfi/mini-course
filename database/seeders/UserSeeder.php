<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Owner',
                'username' => 'owner',
                'email' => 'owner@localhost.com',
                'password' => bcrypt('owner123'),
                'role' => 'owner'
            ],
            [
                'name' => 'Mentor',
                'username' => 'mentor',
                'email' => 'mentor@localhost.com',
                'password' => bcrypt('mentor123'),
                'role' => 'mentor'
            ],
            [
                'name' => 'Mentee 1',
                'username' => 'mentee',
                'email' => 'mentee@localhost.com',
                'password' => bcrypt('mentee123'),
                'role' => 'mentee'
            ]
        ]);
    }
}
