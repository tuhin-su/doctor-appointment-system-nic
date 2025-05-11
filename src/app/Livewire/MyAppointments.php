<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AppointmentsBooking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MyAppointments extends Component
{
    public $appointments;
    public $currentMonth;
    public $currentYear;
    public $daysInMonth;
    public $availableDays = [];
    public $selectedDate;
    public $selectedAppointments = [];
    public $showRescheduleModal = false;
    public $appointmentId;
    public $newDate;
    public $newTime;

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->appointments = AppointmentsBooking::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->orderBy('booking_time')
            ->get();

        $this->calculateAvailableDays();
    }

    public function calculateAvailableDays()
    {
        $this->availableDays = [];
        $this->daysInMonth = Carbon::create($this->currentYear, $this->currentMonth)->daysInMonth;

        // Get the booked dates
        foreach ($this->appointments as $appointment) {
            $appointmentDate = Carbon::parse($appointment->date);
            if ($appointmentDate->month == $this->currentMonth && $appointment->user_id == Auth::id()) {
                $this->availableDays[] = $appointmentDate->day;
            }
        }
    }

    public function selectDate($day)
    {
        // Set the selected date
        $this->selectedDate = Carbon::create($this->currentYear, $this->currentMonth, $day)->toDateString();
        
        // Load appointments for this selected date
        $this->loadAppointmentsForSelectedDate();
    }

    public function loadAppointmentsForSelectedDate()
    {
        $this->selectedAppointments = AppointmentsBooking::where('user_id', Auth::id())
            ->where('date', $this->selectedDate)
            ->with('doctor.user') // Eager load doctor info
            ->get();
    }

    public function cancelAppointment($appointmentId)
    {
        $appointment = AppointmentsBooking::find($appointmentId);
        if ($appointment && $appointment->user_id == Auth::id()) {
            $appointment->delete();
            session()->flash('message', 'Appointment cancelled successfully!');
            $this->loadAppointmentsForSelectedDate();  // Re-load appointments for the selected date
        }
    }

    // Reschedule Methods
    public function openRescheduleModal($appointmentId)
    {
        $this->appointmentId = $appointmentId;
        $this->showRescheduleModal = true;
    }

    public function closeRescheduleModal()
    {
        $this->showRescheduleModal = false;
    }

    public function rescheduleAppointment()
    {
        $appointment = AppointmentsBooking::find($this->appointmentId);
        
        if ($appointment && $appointment->user_id == Auth::id()) {
            $appointment->date = Carbon::parse($this->newDate);
            $appointment->booking_time = $this->newTime;
            $appointment->save();

            session()->flash('message', 'Appointment rescheduled successfully!');
            $this->closeRescheduleModal();
            $this->loadAppointmentsForSelectedDate();  // Re-load appointments for the selected date
        }
    }

    public function incrementMonth()
    {
        $this->currentMonth = ($this->currentMonth % 12) + 1;
        if ($this->currentMonth == 1) {
            $this->currentYear++;
        }
        $this->calculateAvailableDays();
    }

    public function decrementMonth()
    {
        $this->currentMonth = ($this->currentMonth == 1) ? 12 : $this->currentMonth - 1;
        if ($this->currentMonth == 12) {
            $this->currentYear--;
        }
        $this->calculateAvailableDays();
    }

    public function render()
    {
        return view('livewire.my-appointments');
    }
}
