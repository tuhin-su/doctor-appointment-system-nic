<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class AppointmentBooking extends Component
{
    public $users;

    public function mount()
    {

        $this->users = User::where('role', 'Doctor')
            ->whereHas('doctors')
            ->with('doctors')
            ->get();
    }

    public function render()
    {
        return view('livewire.appointment-booking', [
            'users' => $this->users
        ]);
    }
}
