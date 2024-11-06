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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('appointment_id');
            $table->dateTime('start_date');
            $table->dateTime('finish_date');
            $table->enum('status', ['earring', 'confirmed', 'canceled'])->default('earring');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Clave foránea para usuarios
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
