<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Add PostgreSQL enum for user_role if it doesn't exist
        DB::statement("DO $$ BEGIN
            IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'user_role') THEN
                CREATE TYPE user_role AS ENUM ('Patient', 'Doctor', 'Admin');
            END IF;
        END$$;");

        if (!Schema::hasTable('migrations')) {
            Schema::create('migrations', function (Blueprint $table) {
                $table->id();
                $table->string('migration');
                $table->integer('batch');
            });
        }

        if (!Schema::hasTable('cache')) {
            Schema::create('cache', function (Blueprint $table) {
                $table->string('key')->primary();
                $table->text('value');
                $table->integer('expiration');
            });
        }

        if (!Schema::hasTable('cache_locks')) {
            Schema::create('cache_locks', function (Blueprint $table) {
                $table->string('key')->primary();
                $table->string('owner');
                $table->integer('expiration');
            });
        }

        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->text('payload');
                $table->integer('last_activity');

                $table->index('last_activity');
                $table->index('user_id');
            });
        }

        if (!Schema::hasTable('password_reset_tokens')) {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }

        if (!Schema::hasTable('jobs')) {
            Schema::create('jobs', function (Blueprint $table) {
                $table->id();
                $table->string('queue');
                $table->text('payload');
                $table->smallInteger('attempts');
                $table->integer('reserved_at')->nullable();
                $table->integer('available_at');
                $table->integer('created_at');

                $table->index('queue');
            });
        }

        if (!Schema::hasTable('job_batches')) {
            Schema::create('job_batches', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('name');
                $table->integer('total_jobs');
                $table->integer('pending_jobs');
                $table->integer('failed_jobs');
                $table->text('failed_job_ids');
                $table->text('options')->nullable();
                $table->integer('cancelled_at')->nullable();
                $table->integer('created_at');
                $table->integer('finished_at')->nullable();
            });
        }

        if (!Schema::hasTable('failed_jobs')) {
            Schema::create('failed_jobs', function (Blueprint $table) {
                $table->id();
                $table->string('uuid')->unique();
                $table->text('connection');
                $table->text('queue');
                $table->text('payload');
                $table->text('exception');
                $table->timestamp('failed_at')->useCurrent();
            });
        }

        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('type');
                $table->string('notifiable_type');
                $table->unsignedBigInteger('notifiable_id');
                $table->text('data');
                $table->timestamp('read_at')->nullable();
                $table->timestamps();

                $table->index(['notifiable_type', 'notifiable_id'], 'notifications_notifiable_type_notifiable_id_index');
            });
        }

        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->text('profile_image')->nullable();
                $table->string('password');
                $table->string('remember_token', 100)->nullable();
                $table->enum('role', ['Patient', 'Doctor', 'Admin'])->default('Patient');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('doctors')) {
            Schema::create('doctors', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->boolean('verified_degree')->default(false);
                $table->string('specialty');
                $table->date('job_started');
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users');
            });
        }

        if (!Schema::hasTable('work_schedule')) {
            Schema::create('work_schedule', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('doctor_id');
                $table->string('day');
                $table->time('start_time');
                $table->time('end_time');
                $table->time('break_start')->nullable();
                $table->time('break_end')->nullable();
                $table->boolean('enabled')->default(true);
                $table->timestamps();

                $table->foreign('doctor_id')->references('id')->on('doctors');
            });
        }

        if (!Schema::hasTable('appointments_booking')) {
            Schema::create('appointments_booking', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('doctor_id');
                $table->unsignedBigInteger('doctor_user_id');
                $table->date('date');
                $table->time('booking_time');
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->string('reschedule_status', 20)->default('booked');
                $table->string('reschedule_by', 200)->nullable();
                $table->date('reschedule_date')->nullable();
                $table->time('reschedule_time')->nullable();
            });

            DB::statement("
                ALTER TABLE appointments_booking
                ADD CONSTRAINT appointments_booking_reschedule_status_check
                CHECK (reschedule_status IN ('pending','approved','declined','completed','booked','cancelled'))
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments_booking');
        Schema::dropIfExists('work_schedule');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('users');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('migrations');

        DB::statement("DROP TYPE IF EXISTS user_role;");
    }
};
