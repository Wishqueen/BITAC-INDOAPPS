<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionItemsTable extends Migration
{
    public function up()
    {
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaction_items');
    }
}
