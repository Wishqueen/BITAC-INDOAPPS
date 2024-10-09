<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class coursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            [
            'title' => 'web dev', 
            'price' => '4000', 
            'duration' => '400', 
            'instructor' => 'putri', 
            'students' => '738', 
            'description' => 'Course 1', 
            'created_at' => now(), 
            'updated_at' => now()],
            [
                'title' => 'UI/UX', 
                'price' => '4000', 
                'duration' => '400', 
                'instructor' => 'putri', 
                'students' => '738', 
                'description' => 'Course 1', 
                'created_at' => now(), 
                'updated_at' => now()],
        ]);
    }
}
