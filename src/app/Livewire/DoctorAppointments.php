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



    public function mount($doctorId = null)
    {
        $this->doctorId = auth()->id();
        $this->loadAppointments();
    }

    public function loadAppointments()
    {
        $this->appointments = AppointmentsBooking::where('doctor_user_id', $this->doctorId)
            ->where(function ($query) {
                $query->whereNull('reschedule_status')
                    ->orWhereNotIn('reschedule_status', ['cancelled', 'pending', 'completed']);
            })
            ->orderBy('date', 'desc')
            ->orderBy('booking_time')
            ->get();
    }

    public function cancelAppointment($appointmentId)
    {
        $appointment = AppointmentsBooking::find($appointmentId);

        if ($appointment && $appointment->doctor_user_id == $this->doctorId) {
            $appointment->reschedule_status = 'cancelled';
            $appointment->save();

            $this->dispatch(
                "alert",
                type: "success",
                title: "Success",
                text: "Appointment cancelled successfully!",
            );

            $appointment->user->notify(new AppointmentCancel($appointment));
        }

        $this->appointments = AppointmentsBooking::where('doctor_user_id', $this->doctorId)
            ->orderBy('date', 'desc')
            ->orderBy('booking_time')
            ->get();
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

    public function render()
    {
        return view('livewire.doctor-appointments');
    }
}
