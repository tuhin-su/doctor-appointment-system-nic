<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\WorkSchedule;
use Livewire\WithPagination;

class DoctorAppointment extends Component
{
    public $workSchedules = [];
    public $successMessage = null;

    protected $rules = [
        'workSchedules.*.start_time' => 'required|date_format:H:i',
        'workSchedules.*.end_time' => 'required|date_format:H:i',
        'workSchedules.*.break_start' => 'nullable|date_format:H:i',
        'workSchedules.*.break_end' => 'nullable|date_format:H:i',
        'workSchedules.*.enabled' => 'boolean',
    ];

    public function mount()
    {
        $user = auth()->user();

        // Make sure the doctor record exists for this user
        $doctor = \App\Models\Doctor::where('user_id', $user->id)->first();

        if (!$doctor) {
            abort(403, 'Access denied: not a registered doctor.');
        }

        $doctorId = $doctor->id; // Use doctor's actual primary key

        // All days
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        $schedules = WorkSchedule::where('doctor_id', $doctorId)->get();

        foreach ($daysOfWeek as $day) {
            $workSchedule = $schedules->firstWhere('day', $day);

            if ($workSchedule) {
                $this->workSchedules[$day] = [
                    'start_time' => $workSchedule->start_time,
                    'end_time' => $workSchedule->end_time,
                    'break_start' => $workSchedule->break_start,
                    'break_end' => $workSchedule->break_end,
                    'enabled' => $workSchedule->enabled,
                ];
            } else {
                $this->workSchedules[$day] = [
                    'start_time' => null,
                    'end_time' => null,
                    'break_start' => null,
                    'break_end' => null,
                    'enabled' => false,
                ];
            }
        }
    }


    public function saveSchedule()
    {
        $doctor = \App\Models\Doctor::where('user_id', auth()->id())->first();

        if (!$doctor) {
            abort(403, 'Doctor not found.');
        }

        $doctorId = $doctor->id;
        $success = false;

        foreach ($this->workSchedules as $day => $schedule) {
            $workSchedule = WorkSchedule::where('doctor_id', $doctorId)->where('day', $day)->first();

            if ($workSchedule) {
                $workSchedule->update([
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time'],
                    'break_start' => $schedule['break_start'],
                    'break_end' => $schedule['break_end'],
                    'enabled' => $schedule['enabled'],
                ]);
            } else {
                WorkSchedule::create([
                    'doctor_id' => $doctorId,
                    'day' => $day,
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time'],
                    'break_start' => $schedule['break_start'],
                    'break_end' => $schedule['break_end'],
                    'enabled' => $schedule['enabled'],
                ]);
            }
            $success = true;
        }

        if ($success) {
            $this->successMessage = "Schedule updated successfully!";
        }
    }


    public function render()
    {
        return view('livewire.doctor-appointment');
    }
}
