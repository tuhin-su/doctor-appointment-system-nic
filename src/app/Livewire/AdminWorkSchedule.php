<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class AdminWorkSchedule extends Component
{
    public $allDoctor;
    public $modify = false;
    public $doctorId;

    public function mount(){
        $this->allDoctor = User::where('role', 'Doctor')->get();
        
    }

    public function openSchedule($doctorId){
        $this->modify = true;
        $this->doctorId = $doctorId;
    }
    
    public function render()
    {
        return view('livewire.admin-work-schedule');
    }
}
