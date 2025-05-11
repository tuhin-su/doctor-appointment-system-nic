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
    public $appointments = [];
    public $selectedDate;
    public $daysInMonth;

    public function mount()
    {
        $this->doctorId = auth()->id(); // Logged in doctor
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->loadAppointments();
    }

    public function loadAppointments()
    {
        $this->appointments = AppointmentsBooking::where('doctor_user_id', $this->doctorId)
            ->whereMonth('date', $this->currentMonth)
            ->whereYear('date', $this->currentYear)
            ->get();

        $this->daysInMonth = Carbon::create($this->currentYear, $this->currentMonth)->daysInMonth;
    }

    public function selectDate($day)
    {
        $this->selectedDate = Carbon::create($this->currentYear, $this->currentMonth, $day)->toDateString();
        $this->appointmentsForSelectedDate = $this->appointments->where('date', $this->selectedDate);
    }

    public function incrementMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->loadAppointments();
    }

    public function decrementMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->loadAppointments();
    }

    public function cancelAppointment($appointmentId)
    {
        $appointment = AppointmentsBooking::findOrFail($appointmentId);

        if ($appointment->doctor_user_id !== $this->doctorId) {
            session()->flash('error', 'You do not have permission to cancel this appointment.');
            return;
        }

        $appointment->delete();

        session()->flash('message', 'Appointment canceled successfully!');
        $this->loadAppointments(); // Refresh appointments
    }

    public function rescheduleAppointment($appointmentId)
    {
        $appointment = AppointmentsBooking::findOrFail($appointmentId);

        if ($appointment->doctor_user_id !== $this->doctorId) {
            session()->flash('error', 'You do not have permission to reschedule this appointment.');
            return;
        }

        // Implement logic to reschedule (you may show a time picker or another form)
        // For now, just a simple flash message.
        session()->flash('message', 'Appointment rescheduled! (Implement rescheduling logic here)');
    }

    public function render()
    {
        return view('livewire.doctor-appointments');
    }
}
