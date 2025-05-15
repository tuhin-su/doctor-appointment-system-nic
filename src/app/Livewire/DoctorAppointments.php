<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AppointmentsBooking;
use App\Notifications\AppointmentCancel;

class DoctorAppointments extends Component
{
    public $doctorId;
    public $appointments;
    public $rescheduling = false;
    public $appointmentId;

    public $search = '';  // Search input from UI

    public function mount($doctorId = null)
    {
        $this->doctorId = auth()->id();
        $this->loadAppointments();
    }

    public function loadAppointments()
    {
        $search = trim($this->search);

        $this->appointments = AppointmentsBooking::with(['user', 'doctor.user'])
            ->where('doctor_user_id', $this->doctorId)
            ->where(function ($query) {
                $query->whereNull('reschedule_status')
                      ->orWhereNotIn('reschedule_status', ['cancelled', 'pending', 'completed']);
            })
            ->where(function ($q) use ($search) {
                if ($search !== '') {
                    $q->whereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'ilike', '%' . $search . '%');  // Postgres case-insensitive search
                    });

                    if ($this->isValidDate($search)) {
                        // Exact date filter, safe because validated
                        $q->orWhereDate('date', $search);
                    }

                    // Also search booking_time as time string (like '08:30')
                    $q->orWhere('booking_time', 'ilike', '%' . $search . '%');
                }
            })
            ->orderBy('date', 'desc')
            ->orderBy('booking_time')
            ->get();
    }

    public function searchAppointments()
    {
        // Called when user clicks search button
        $this->loadAppointments();
    }

    public function cancelAppointment($appointmentId)
    {
        $appointment = AppointmentsBooking::find($appointmentId);

        if ($appointment && $appointment->doctor_user_id == $this->doctorId) {
            $appointment->reschedule_status = 'cancelled';
            $appointment->save();

            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'title' => 'Success',
                'text' => 'Appointment cancelled successfully!',
            ]);

            $appointment->user->notify(new AppointmentCancel($appointment));
            $this->loadAppointments();
        }
    }

    public function rescheduleAppointment($appointmentId)
    {
        $this->rescheduling = true;
        $this->appointmentId = $appointmentId;
    }

    public function cancelReschedule()
    {
        $this->rescheduling = false;
    }

    private function isValidDate($date)
    {
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    public function render()
    {
        return view('livewire.doctor-appointments');
    }
}
