<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AppointmentsBooking;
use Carbon\Carbon;

class DoctorAppointments extends Component
{
    public $doctorId;
    public $currentMonth;
    public $currentYear;
    public $appointments;
    public $selectedDate;
    public $appointmentsForSelectedDate = [];
    public $daysInMonth;

    public function mount()
    {
        $this->doctorId = auth()->id();
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->loadAppointments();
    }

    public function loadAppointments()
    {
        // Load all appointments for the doctor for the current month and year
        $this->appointments = AppointmentsBooking::where('doctor_user_id', $this->doctorId)
            ->whereMonth('date', $this->currentMonth)
            ->whereYear('date', $this->currentYear)
            ->get();

        $this->daysInMonth = Carbon::create($this->currentYear, $this->currentMonth)->daysInMonth;
    }

    public function selectDate($day)
    {
        $this->selectedDate = Carbon::create($this->currentYear, $this->currentMonth, $day)->toDateString();

        $this->appointmentsForSelectedDate = $this->appointments->filter(function ($appointment) {
            return Carbon::parse($appointment->date)->toDateString() === $this->selectedDate;
        });
    }


    public function incrementMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->loadAppointments();
    }

    public function decrementMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->loadAppointments();
    }

    public function render()
    {
        return view('livewire.doctor-appointments');
    }
}
