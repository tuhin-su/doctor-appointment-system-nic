<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Collection;

class AppointmentBooking extends Component
{
    public $search = '';
    public $specialty = '';
    public $users;

    public $bookingMode = false;
    public $doctorId;

    public function mount()
    {
        $this->loadUsers();
    }

    public function searchQuery()
    {
        $this->loadUsers();
    }

    public function updatedSpecialty()
    {
        $this->loadUsers();
    }

    private function loadUsers()
    {
        $this->users = User::where('role', 'Doctor')
            ->whereHas('doctors', function ($query) {
                $query->when($this->specialty, function ($q) {
                    $q->where('specialty', 'like', '%' . $this->specialty . '%');
                });
            })
            ->with(['doctors', 'doctors.workSchedules'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->get();
    }

    public function openBookingForm($userId)
    {
        $this->bookingMode = true;
        $this->doctorId = $userId;
    }

    public function render()
    {
        return view('livewire.appointment-booking');
    }
}
