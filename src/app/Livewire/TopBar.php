<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TopBar extends Component
{
    public $menu = [];

    public function mount()
    {
        $user = Auth::user();
        $role = $user?->role ?? 'Guest'; // fallback role

        $allMenus =  [
            [
                'title' => 'Dashboard',
                'route' => 'dashboard',
                'roles' => ['Admin', 'Doctor', 'Patient'],
                'icon' => 'ri-pie-chart-box-line',
                'icon_color' => 'text-indigo-500',
            ],
            [
                'title' => 'Management',
                'roles' => ['Admin'],
                'children' => [
                    ['title' => 'Users', 'route' => 'user-master', 'roles' => ['Admin'], 'icon' => 'ri-pass-valid-line', 'icon_color' => 'text-emerald-500'],
                    ['title' => 'Work Schedule', 'route' => 'dashboard', 'roles' => ['Admin'], 'icon' => 'ri-empathize-line', 'icon_color' => 'text-teal-500'],
                ],
                'icon' => 'ri-briefcase-fill',
                'icon_color' => 'text-green-500',
            ],
            [
                'title' => 'Appointment System',
                'roles' => ['Admin', 'Doctor', 'Patient'],
                'children' => [
                    ['title' => 'Appointments', 'route' => 'doctor-appointment', 'roles' => ['Admin', 'Doctor'], 'icon' => 'ri-time-line', 'icon_color' => 'text-cyan-500'],
                    ['title' => 'Book Appointment', 'route' => 'appointment-booking', 'roles' => ['Patient'], 'icon' => 'ri-calendar-event-fill', 'icon_color' => 'text-sky-500'],
                    ['title' => 'My Appointments', 'route' => 'my-appointments', 'roles' => ['Patient'], 'icon' => 'ri-calendar-check-fill', 'icon_color' => 'text-blue-500'],
                    ['title' => 'Manage Appointments', 'route' => 'dashboard', 'roles' => ['Doctor'], 'icon' => 'ri-calendar-check-fill', 'icon_color' => 'text-blue-500'],
                ],
                'icon' => 'ri-calendar-todo-fill',
                'icon_color' => 'text-light-blue-500',
            ],
            [
                'title' => 'Reports',
                'roles' => ['Admin', 'Patient'],
                'children' => [
                    ['title' => 'Reports', 'route' => 'dashboard', 'roles' => ['Admin'], 'icon' => 'ri-file-list-3-line', 'icon_color' => 'text-rose-500'],
                    ['title' => 'Search Doctors', 'route' => 'dashboard', 'roles' => ['Patient'], 'icon' => 'ri-briefcase-fill', 'icon_color' => 'text-pink-500'],
                ],
                'icon' => 'ri-file-chart-2-fill',
                'icon_color' => 'text-red-500',
            ],
            [
                'title' => 'Notifications',
                'route' => 'dashboard',
                'roles' => ['Admin', 'Doctor', 'Patient'],
                'icon' => 'ri-notification-fill',
                'icon_color' => 'text-purple-500',
            ],
        ];


        $this->menu = collect($allMenus)->filter(fn($item) => in_array($role, $item['roles']))->all();
    }



    public function render()
    {
        return view('livewire.top-bar');
    }
}
