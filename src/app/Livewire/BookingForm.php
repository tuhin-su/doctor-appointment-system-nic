<?php

namespace App\Livewire;

use App\Models\Doctor;
use Livewire\Component;
use App\Models\WorkSchedule;
use App\Models\AppointmentsBooking;
use Carbon\Carbon;
use App\Notifications\AppointmentReminder;
use App\Notifications\AppointmentBooked;


class BookingForm extends Component
{
    public $doctorId;
    public $doctor;
    public $currentMonth;
    public $currentYear;
    public $availableDays = [];
    public $selectedDate;
    public $availableTimes = [];
    public $daysInMonth;

    public function mount($doctorId)
    {
        $this->doctorId = $doctorId;
        $this->doctor = Doctor::where('user_id', $this->doctorId)->firstOrFail();
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;

        $this->calculateAvailableDays();
    }

    public function calculateAvailableDays()
    {
        $this->availableDays = [];
        $schedules = $this->doctor->work_schedules;
        $this->daysInMonth = Carbon::create($this->currentYear, $this->currentMonth)->daysInMonth;

        for ($day = 1; $day <= $this->daysInMonth; $day++) {
            $date = Carbon::create($this->currentYear, $this->currentMonth, $day);
            $dayName = $date->format('l');
            $schedule = $schedules->firstWhere('day', $dayName);

            // If a schedule exists and is enabled, add the date
            if ($schedule && $schedule->enabled) {
                $this->availableDays[] = $day;
            }
        }
    }



    public function selectDate($day)
    {
        $this->selectedDate = Carbon::create($this->currentYear, $this->currentMonth, $day)->toDateString();
        $this->loadAvailableTimeSlots();
    }

    public function loadAvailableTimeSlots()
    {
        $date = Carbon::parse($this->selectedDate);
        $dayName = $date->format('l');

        $schedule = $this->doctor->work_schedules->firstWhere('day', $dayName);

        if (!$schedule || !$schedule->enabled) {
            $this->availableTimes = [];
            return;
        }

        $start = Carbon::parse($schedule->start_time);
        $end = Carbon::parse($schedule->end_time);
        $breakStart = $schedule->break_start ? Carbon::parse($schedule->break_start) : null;
        $breakEnd = $schedule->break_end ? Carbon::parse($schedule->break_end) : null;

        $slots = [];

        while ($start->lt($end)) {
            $slot = $start->format('H:i');

            if ($breakStart && $breakEnd && $start->between($breakStart, $breakEnd->subMinute())) {
                $start->addMinutes(30);
                continue;
            }

            $exists = AppointmentsBooking::where('doctor_user_id', $this->doctorId)
                ->where('date', $this->selectedDate)
                ->where('booking_time', $slot)
                ->exists();

            if (!$exists) {
                $slots[] = $slot;
            }

            $start->addMinutes(30);
        }

        $this->availableTimes = $slots;
    }


    public function incrementMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->calculateAvailableDays();
    }

    public function decrementMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->calculateAvailableDays();
    }

    public function bookSlot($time)
    {
        $date = Carbon::parse($this->selectedDate);
        $dayName = $date->format('l');

        $schedule = $this->doctor->work_schedules->firstWhere('day', $dayName);

        if (!$schedule || !$schedule->enabled) {
            $this->dispatch(
                "alert",
                type: "error",
                title: "Error",
                text: "Selected date is not available for booking.",
            );
            return;
        }

        $start = Carbon::parse($schedule->start_time);
        $end = Carbon::parse($schedule->end_time);
        $breakStart = $schedule->break_start ? Carbon::parse($schedule->break_start) : null;
        $breakEnd = $schedule->break_end ? Carbon::parse($schedule->break_end) : null;

        $slotTime = Carbon::parse($time);

        // Check if time is within working hours
        if ($slotTime->lt($start) || $slotTime->gte($end)) {
            $this->dispatch(
                "alert",
                type: "error",
                title: "Error",
                text: "Selected time is outside of working hours.",
            );
            return;
        }

        // Check if time is during break
        if ($breakStart && $breakEnd && $slotTime->between($breakStart, $breakEnd->subMinute())) {
            $this->dispatch(
                "alert",
                type: "error",
                title: "Error",
                text: "Selected time is during break hours.",
            );
            return;
        }

        // Check if time is already booked
        $exists = AppointmentsBooking::where('doctor_user_id', $this->doctorId)
            ->where('date', $this->selectedDate)
            ->where('booking_time', $time)
            ->exists();

        if ($exists) {
            $this->dispatch(
                "alert",
                type: "error",
                title: "Error",
                text: "Selected time slot is already booked.",
            );
            return;
        }

        // All checks passed, save appointment
        $appointment = AppointmentsBooking::create([
            'user_id' => auth()->id(),
            'doctor_id' => $this->doctor->id,
            'doctor_user_id' => $this->doctorId,
            'date' => $this->selectedDate,
            'booking_time' => $time,
        ]);

        $appointment->patientUser->notify(new AppointmentBooked($appointment));
        $appointment->doctorUser->notify(new AppointmentBooked($appointment));

        $reminderTime = Carbon::parse("{$appointment->date} {$appointment->time}")->subDay();
        $appointment->patientUser
            ->notify((new AppointmentReminder($appointment))->delay($reminderTime));

        $this->dispatch(
            "alert",
            type: "success",
            title: "Success",
            text: "Appointment booked successfully.",
        );
        $this->loadAvailableTimeSlots();
    }



    public function render()
    {
        return view('livewire.booking-form');
    }
}
