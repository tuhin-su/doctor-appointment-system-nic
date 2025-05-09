<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserMaster extends Component
{
    public $users;
    public $viewMode = true;

    public $user;
    public $name;
    public $email;
    public $role;
    public $specialty;
    public $verified_degree;
    public $job_started;

    public function mount()
    {
        $this->users = User::all();
    }

    public function openEditForm($userId)
    {
        $this->viewMode = false;
        $this->user = User::findOrFail($userId);

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role = $this->user->role;
    }

    public function roleChanged()
    {
        if ($this->role === 'Doctor') {
            $doctor = $this->user->doctors()->first();
            $this->specialty = $doctor?->specialty ?? '';
            $this->verified_degree = $doctor?->verified_degree ?? false;
            $this->job_started = $doctor?->job_started?->format('Y-m-d') ?? '';
        }
    }

    public function saveUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required',
        ]);

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ]);

        // Save doctor data if role is Doctor
        if ($this->role === 'Doctor') {
            $this->user->doctors()->updateOrCreate([], [
                'specialty' => $this->specialty,
                'verified_degree' => $this->verified_degree,
                'job_started' => $this->job_started,
            ]);
        }

        session()->flash('message', 'User updated successfully!');
        $this->closeEditForm();
    }

    public function closeEditForm()
    {
        $this->viewMode = true;
    }

    public function render()
    {
        return view('livewire.user-master');
    }
}
