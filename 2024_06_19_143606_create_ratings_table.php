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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('accommodation_id');
            //$table->unsignedTinyInteger('rating'); // assuming ratings are integers from 1 to 5
            $table->integer('rating')->nullable(); // Make the rating column nullable
            $table->text('review')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('accommodation_id')->references('id')->on('accommodations');
            $table->foreign('accommodation_id')->references('id')->on('accommodations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
