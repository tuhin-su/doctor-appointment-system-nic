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
        if (!Schema::hasTable('work_schedule')) {
            Schema::create('work_schedule', function (Blueprint $table) {
                $table->increments('id');
                $table->increments('doctor_id');
                $table->string('day');
                $table->time('start_time');
                $table->time('end_time');
                $table->time('break_start')->nullable();
                $table->time('break_end')->nullable();
                $table->boolean('enabled')->nullable()->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_schedule');
    }
};
