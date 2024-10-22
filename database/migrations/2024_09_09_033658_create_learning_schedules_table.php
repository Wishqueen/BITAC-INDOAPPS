<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('learning_schedules', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // Day of the week
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); // Foreign key to courses table
            $table->text('material')->nullable(); // Material for the schedule
            $table->time('start_time');
            $table->time('end_time');  // Time for the schedule
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade'); // Foreign key to users table for instructor
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_schedules');
    }
};
