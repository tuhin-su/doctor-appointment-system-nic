<?php

namespace App\Livewire;

use App\Models\AppointmentsBooking;
use App\Models\WorkSchedule;
use Livewire\Component;
use Carbon\Carbon;


class MyAppointments extends Component
{
    public function render()
    {
        return view('livewire.my-appointments');
    }
}
