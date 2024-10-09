<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first course ID
        $courseIds = DB::table('courses')->pluck('id')->toArray();

        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'Admin',
                'course_id' => null, // Admin doesn't need a course ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Putri Indah',
                'email' => 'putriindah032002@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'student',
                'course_id' => $courseIds[0],// Use the first course ID for the student
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'USER',
                'email' => 'user@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'student',
                'course_id' => $courseIds[1], // Use the first course ID for the student
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

