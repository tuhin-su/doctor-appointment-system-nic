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
        Schema::create('appointments_booking', function (Blueprint $table) {
            $table->increments('id');
            $table->increments('user_id');
            $table->increments('doctor_id');
            $table->increments('doctor_user_id');
            $table->date('date');
            $table->time('booking_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments_booking');
    }
};
