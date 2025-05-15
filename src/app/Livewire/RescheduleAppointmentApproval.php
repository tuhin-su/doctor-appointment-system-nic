<?php
namespace App\Livewire;

use App\Models\AppointmentsBooking;
use Livewire\Component;

class RescheduleAppointmentApproval extends Component
{
    public $pendingAppointments = [];

    public function mount()
    {
        $this->loadPendingAppointments();
    }

    public function loadPendingAppointments()
    {
        if (auth()->user()->role == 'Doctor') {
            $this->pendingAppointments = AppointmentsBooking::with(['patientUser', 'doctorUser'])
            ->where('reschedule_status', 'pending')
            ->where('reschedule_by', 'Patient')
            ->where('doctor_user_id', auth()->user()->id)
            ->orderBy('date')
            ->get();
        } else {
            $this->pendingAppointments = AppointmentsBooking::with(['patientUser', 'doctorUser'])
            ->where('reschedule_status', 'pending')
            ->where('reschedule_by', 'Doctor')
            ->where('user_id', auth()->user()->id)
            ->orderBy('date')
            ->get();
        }
    }

    public function approve($appointmentId)
    {
        $appointment = AppointmentsBooking::find($appointmentId);

        if ($appointment) {
            $appointment->update([
                'booking_time' => $appointment->reschedule_time,
                'date' => $appointment->reschedule_date,
                'reschedule_status' => 'approved'
            ]);
            $this->dispatch('alert', type: 'success', title: 'Approved', text: 'Appointment reschedule approved.');
            $this->loadPendingAppointments();
        }
    }

    public function reject($appointmentId)
    {
        $appointment = AppointmentsBooking::find($appointmentId);

        if ($appointment) {
            $appointment->update(['reschedule_status' => 'rejected']);
            $this->dispatch('alert', type: 'error', title: 'Rejected', text: 'Appointment reschedule rejected.');
            $this->loadPendingAppointments();
        }
    }

    public function render()
    {
        return view('livewire.reschedule-appointment-approval');
    }
}
