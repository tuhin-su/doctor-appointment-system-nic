<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\AppointmentsBooking;
use Carbon\Carbon;

class AppointmentBookingSeeder extends Seeder
{
    public function run()
    {
        $n = 100; // Number of total appointments to insert

        $users = User::all();
        $doctors = Doctor::with('user')->get();

        if ($users->isEmpty() || $doctors->isEmpty()) {
            $this->command->warn('No users or doctors available.');
            return;
        }

        for ($i = 0; $i < $n; $i++) {
            $doctor = $doctors->random();
            $user = $users->random();

            // Random date within next 30 days
            $date = Carbon::now()->addDays(rand(0, 30))->toDateString();

            // Random time between 9:00 and 17:00 (working hours)
            $hour = rand(9, 16); // 16 because we add 30 min
            $minute = rand(0, 1) === 0 ? '00' : '30';
            $time = sprintf('%02d:%s:00', $hour, $minute);

            AppointmentsBooking::create([
                'user_id' => $user->id,
                'doctor_id' => $doctor->id,
                'doctor_user_id' => $doctor->user_id,
                'date' => $date,
                'booking_time' => $time,
                'reschedule_status' => 'booked',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info("Inserted {$n} random test appointments.");
    }
}
