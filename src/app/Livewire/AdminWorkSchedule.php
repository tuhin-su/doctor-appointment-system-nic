<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class AdminWorkSchedule extends Component
{
    public $allDoctor;
    public $modify = false;
    public $doctorId;

    public $search = ''; // Search input

    public function mount()
    {
        $this->loadDoctors();
    }

    public function loadDoctors($searchTerm = null)
    {
        $query = User::where('role', 'Doctor');

        if ($searchTerm) {
            $searchTerm = '%' . $searchTerm . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'ilike', $searchTerm)
                  ->orWhere('email', 'ilike', $searchTerm);
            });
        }

        $this->allDoctor = $query->get();
    }

    public function searchDoctors()
    {
        $this->loadDoctors($this->search);
    }

    public function openSchedule($doctorId)
    {
        $this->modify = true;
        $this->doctorId = $doctorId;
    }

    public function render()
    {
        return view('livewire.admin-work-schedule');
    }
}
