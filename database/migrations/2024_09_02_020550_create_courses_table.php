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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('price', 10, 2); // Decimal with larger precision
            $table->decimal('discount', 5, 2)->nullable(); // Discount percentage
            $table->decimal('discounted_price', 10, 2)->nullable(); // Final price after discount // Discount column, nullable
            $table->string('duration');
            $table->string('instructor');
            $table->integer('students');
            $table->string('image')->nullable();
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
