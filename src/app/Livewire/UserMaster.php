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

    public $search = ''; // Search input

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers($searchTerm = null)
    {
        $query = User::query();

        if ($searchTerm) {
            $searchTerm = '%' . $searchTerm . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'ilike', $searchTerm)
                  ->orWhere('email', 'ilike', $searchTerm)
                  ->orWhere('role', 'ilike', $searchTerm);
            });
        }

        $this->users = $query->get();
    }

    public function searchUsers()
    {
        $this->loadUsers($this->search);
    }

    public function openEditForm($userId)
    {
        $this->viewMode = false;
        $this->user = User::findOrFail($userId);

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role = $this->user->role;

        $this->roleChanged();
    }

    public function roleChanged()
    {
        if ($this->role === 'Doctor') {
            $doctor = $this->user->doctors()->first();
            $this->specialty = $doctor?->specialty ?? '';
            $this->verified_degree = $doctor?->verified_degree ?? false;
            $this->job_started = $doctor?->job_started?->format('Y-m-d') ?? '';
        } else {
            $this->specialty = '';
            $this->verified_degree = false;
            $this->job_started = null;
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

        if ($this->role === 'Doctor') {
            $this->user->doctors()->updateOrCreate([], [
                'specialty' => $this->specialty,
                'verified_degree' => $this->verified_degree,
                'job_started' => $this->job_started,
            ]);
        }

        $this->dispatchBrowserEvent('alert', [
            'type' => 'success',
            'title' => 'Success',
            'text' => 'User updated successfully!',
        ]);

        $this->closeEditForm();
        $this->loadUsers(); // Refresh users list
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
