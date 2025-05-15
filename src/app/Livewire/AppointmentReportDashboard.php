<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AppointmentsBooking;
use App\Models\User;

class AppointmentReportDashboard extends Component
{
    public $totalAppointments;
    public $rescheduledAppointments;
    public $usersWithNoAppointments;

    public function mount()
    {
        $this->totalAppointments = AppointmentsBooking::count();
        $this->rescheduledAppointments = AppointmentsBooking::whereNotNull('reschedule_status')->count();
        $this->usersWithNoAppointments = User::where('role', 'Patient')
        ->whereDoesntHave('appointmentsBooking')
        ->count();
    }

    public function render()
    {
        return view('livewire.appointment-report-dashboard');
    }
}
