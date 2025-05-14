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
        if (!Schema::hasTable('appointments_booking')) {
            Schema::create('appointments_booking', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('doctor_id');
                $table->unsignedBigInteger('doctor_user_id');
                $table->date('date');
                $table->time('booking_time');
                $table->timestamps();
                $table->enum('reschedule_status', ['pending', 'approved', 'declined', 'completed', 'booked', 'cancelled'])->nullable();
                $table->string('reschedule_by')->nullable();
                $table->date('reschedule_date')->nullable();
                $table->time('reschedule_time')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments_booking');
    }
};
