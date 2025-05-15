<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\AppointmentsBooking;
use Carbon\Carbon;
use Livewire\Component;
use App\Notifications\AppointmentRescheduled;

class RescheduleAppointmentForm extends Component
{
    public $appointmentId;
    public $appointment;
    public $doctor;
    public $selectedDate;
    public $availableTimes = [];
    public $currentMonth;
    public $currentYear;
    public $daysInMonth;

    public function mount($appointmentId)
    {
        $this->appointmentId = $appointmentId;
        $this->appointment = AppointmentsBooking::findOrFail($this->appointmentId);
        $this->doctor = Doctor::find($this->appointment->doctor_id);
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->selectedDate = $this->appointment->date;
        $this->calculateAvailableTimes();
    }

    public function calculateAvailableTimes()
    {
        $schedule = $this->doctor->work_schedules->firstWhere('day', Carbon::parse($this->selectedDate)->format('l'));
        $this->daysInMonth = Carbon::create($this->currentYear, $this->currentMonth)->daysInMonth;

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

            // Check if within break
            if ($breakStart && $breakEnd && $start->between($breakStart, $breakEnd->subMinute())) {
                $start->addMinutes(30);
                continue;
            }

            $exists = AppointmentsBooking::where('doctor_user_id', $this->doctor->user_id)
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

    public function rescheduleAppointment($newTime)
    {
        $newTime = Carbon::parse($newTime);
        $appointment = $this->appointment;
    
        // Ensure that the doctor has a work schedule
        $schedule = $appointment->doctor->work_schedules->firstWhere('day', Carbon::parse($this->selectedDate)->format('l'));
    
        if (!$schedule) {
            $this->dispatch("alert", type: "error", title: "Error", text: "Doctor's schedule is not available for the selected date.");
            return;
        }
    
        // Check if the new time is valid within the doctor's working hours
        if ($newTime->lt(Carbon::parse($schedule->start_time)) || $newTime->gte(Carbon::parse($schedule->end_time))) {
            $this->dispatch("alert", type: "error", title: "Error", text: "Selected time is outside working hours.");
            return;
        }
    
        // Check if the time is already booked
        $exists = AppointmentsBooking::where('doctor_user_id', $this->doctor->user_id)
            ->where('date', $this->selectedDate)
            ->where('booking_time', $newTime->format('H:i'))
            ->exists();
    
        if ($exists) {
            $this->dispatch("alert", type: "error", title: "Error", text: "Selected time is already booked.");
            return;
        }
    
        // Set the new reschedule request
        $appointment->update([
            'reschedule_date' => $this->selectedDate,
            'reschedule_time' => $newTime->format('H:i'),
            'reschedule_status' => 'pending',
            'reschedule_by' => auth()->user()->role,
        ]);

        // Notify the doctor and patient
        $this->appointment->patientUser->notify(new AppointmentRescheduled($appointment));
        $this->appointment->doctorUser->notify(new AppointmentRescheduled($appointment));
    
        $this->dispatch("alert", type: "success", title: "Success", text: "Reschedule request sent.");
    }
    

    public function incrementMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->calculateAvailableTimes();
    }

    public function decrementMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->calculateAvailableTimes();
    }

    public function selectDate($day)
    {
        $this->selectedDate = Carbon::create($this->currentYear, $this->currentMonth, $day)->toDateString();
        $this->calculateAvailableTimes();
    }

    public function render()
    {
        return view('livewire.reschedule-appointment-form');
    }
}
