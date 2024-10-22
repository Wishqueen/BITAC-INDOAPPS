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
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade'); // Foreign key to users table, with cascading delete

            $table->foreignId('course_id')
                ->constrained('courses')
                ->onDelete('cascade'); // Foreign key to courses table, with cascading delete
            $table->string('certificate_number');
            $table->string('title')->nullable();; // Title of the certification
            $table->text('description'); // Description of the certification
            $table->string('image')->nullable(); // URL or path to the image, make nullable if it's optional
            $table->date('date')->nullable(); // Date field for certification date
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
