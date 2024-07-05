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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->timestamps(); 
            $table->date('start_date');      //add to the form - or should be when the owner press confirmation
                                             //== created_at->addDays(5)->format('Y-m-d')
            $table->date('end_date');          //should be in the form, the user will enter the date
            //$table->foreignId('user_id')->constrained();
          
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->unsignedBigInteger('accommodations_id');
            $table->foreign('accommodations_id')->references('id')->on('accommodations')->onDelete('cascade');
            $table->string('receipt');
            $table->boolean('confirmed')->default(false);
            $table->string('reference_number')->nullable()->default(null);
            //$table->string('receipt'); //>>should be image
            //$table->boolean('confirmed')->default(false);
            //$table->string('reference_number')->nullable()->default(null);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
