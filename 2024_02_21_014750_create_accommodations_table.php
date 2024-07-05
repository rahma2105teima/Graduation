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
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('address');
            $table->string('location_link');
            $table->string('governorate');
            $table->string('region');
            $table->decimal('price', 10, 2);
            // $table->string('availability')->default('available');
            $table->text('facilities');
            $table->enum('shared_or_individual', ['shared', 'individual']);
            $table->unsignedBigInteger('owner_id');
            $table->integer('no_of_tenants');//->nullable()->default(1);                              
            $table->integer('no_of_tenants_available')->nullable()->default(1);
            $table->string('images');
            // $table->json('images'); // Change the column type to text

            $table->string('main_image')->nullable(false); // Explicitly specifying that it's not nullable
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodations');
    }
};
