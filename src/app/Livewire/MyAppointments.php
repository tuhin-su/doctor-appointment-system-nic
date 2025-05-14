<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AppointmentsBooking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Notifications\AppointmentCancel;
use App\Livewire\BookingForm;
class MyAppointments extends Component
{
    public $appointments;
    public $appointmentId;
    public $rescheduling = false;

    public function mount()
    {
        $this->appointments = AppointmentsBooking::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->orderBy('booking_time')
            ->get();
    }


    public function cancelAppointment($appointmentId)
{
    $appointment = AppointmentsBooking::find($appointmentId);

    if ($appointment && $appointment->user_id == Auth::id()) {
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

    $this->appointments = AppointmentsBooking::where('user_id', Auth::id())
        ->orderBy('date', 'desc')
        ->orderBy('booking_time')
        ->get();
}

    public function rescheduleAppointment($appointmentId)
    {
        $this->appointmentId = $appointmentId;
        $this->rescheduling = true;
    }

    public function cancelReschedule()
    {
        $this->rescheduling = false;
    }

    public function render()
    {
        return view('livewire.my-appointments');
    }
}
