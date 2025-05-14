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
        Schema::table('appointments_booking', function (Blueprint $table) {
            $table->foreign(['doctor_id'], 'appointments_booking_doctor_id_fkey')->references(['id'])->on('doctors')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['doctor_user_id'], 'appointments_booking_doctor_user_id_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'], 'appointments_booking_user_id_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments_booking', function (Blueprint $table) {
            $table->dropForeign('appointments_booking_doctor_id_fkey');
            $table->dropForeign('appointments_booking_doctor_user_id_fkey');
            $table->dropForeign('appointments_booking_user_id_fkey');
        });
    }
};
