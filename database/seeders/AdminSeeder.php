<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Seed admin user ke database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'), // Pastikan ini adalah password yang aman
                'role' => 'admin', // Asumsikan ada field role
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Instructor',
                'email' => 'instructor@gmail.com',
                'password' => Hash::make('12345678'), // Pastikan ini adalah password yang aman
                'role' => 'instructor', // Asumsikan ada field role
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Student',
                'email' => 'student@gmail.com',
                'password' => Hash::make('12345678'), // Pastikan ini adalah password yang aman
                'role' => 'student', // Asumsikan ada field role
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
