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
                $table->string('title'); // Judul kegiatan
                $table->text('description')->nullable(); // Deskripsi kegiatan
                $table->dateTime('start'); // Waktu mulai
                $table->dateTime('end');  // Waktu berakhir
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
