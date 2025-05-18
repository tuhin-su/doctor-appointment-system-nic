<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AppointmentsBooking;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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

            $startDate = Carbon::create(2025, 5, 1)->toDateString();
            $endDate = Carbon::create(2025, 5, 31)->toDateString();
            
            $results = AppointmentsBooking::select(
                    'doctor_id',
                    DB::raw('COUNT(*) as total_appointments')
                )
                ->with([
                    'doctor' => function ($query) {
                        $query->select('id', 'user_id', 'specialty');
                    },
                    'doctor.user:id,name,email'
                ])
                ->where('user_id', 1)
                ->whereBetween('date', [$startDate, $endDate])
                ->groupBy('doctor_id')
                ->orderByDesc('total_appointments')
                ->limit(100)
                ->get();
            
            echo json_encode($results);
    }

    public function render()
    {
        return view('livewire.appointment-report-dashboard');
    }
}
