<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AppointmentsBooking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Notifications\AppointmentCancel;
use Livewire\WithPagination;

class MyAppointments extends Component
{
    use WithPagination;

    public $appointments;
    public $appointmentId;
    public $rescheduling = false;
    public $search = '';

    public function mount()
    {
        $this->fetchAppointments();
    }

    public function searchAppointments()
    {
        $this->fetchAppointments();
    }

    public function fetchAppointments()
    {
        $query = AppointmentsBooking::with(['doctor.user'])
            ->where('reschedule_status', 'booked')
            ->where('user_id', Auth::id());

        if ($this->search) {
            $search = trim($this->search);

            $query->where(function ($q) use ($search) {
                $q->whereHas('doctor.user', function ($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search . '%');
                });

                // Add date condition if valid date in Y-m-d format
                if ($this->isValidDate($search)) {
                    $q->orWhereDate('date', $search);
                }

                // Add time condition if valid time in HH:mm or H:mm format
                if ($this->isValidTime($search)) {
                    $q->orWhere('booking_time', 'like', '%' . $search . '%');
                }
            });
        }

        $this->appointments = $query
            ->orderBy('date', 'desc')
            ->orderBy('booking_time')
            ->get();
    }

    private function isValidDate($date)
    {
        // Strict Y-m-d validation
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    private function isValidTime($time)
    {
        // Validate time as HH:mm or H:mm using regex
        return preg_match('/^(?:2[0-3]|[01]?[0-9]):[0-5][0-9]$/', $time);
    }

    public function cancelAppointment($appointmentId)
    {
        $appointment = AppointmentsBooking::find($appointmentId);

        if ($appointment && $appointment->user_id == Auth::id()) {
            $appointment->reschedule_status = 'cancelled';
            $appointment->save();

            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'title' => 'Success',
                'text' => 'Appointment cancelled successfully!',
            ]);

            $appointment->user->notify(new AppointmentCancel($appointment));
        }

        $this->fetchAppointments();
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
