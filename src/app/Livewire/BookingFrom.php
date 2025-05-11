<?php
use App\Models\Doctor;
use App\Models\WorkSchedule;
use App\Models\AppointmentsBooking;
use Carbon\Carbon;
use Livewire\Component;

class BookingForm extends Component
{
    public $userId; // This is doctor_user_id
    public $doctor;
    public $currentMonth;
    public $currentYear;
    public $availableDays = [];
    public $selectedDate;
    public $availableTimes = [];

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->doctor = Doctor::where('user_id', $this->userId)->firstOrFail();
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;

        $this->calculateAvailableDays();
    }

    public function calculateAvailableDays()
    {
        $this->availableDays = [];
        $schedules = $this->doctor->work_schedules;

        $daysInMonth = Carbon::create($this->currentYear, $this->currentMonth)->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($this->currentYear, $this->currentMonth, $day);
            $dayOfWeek = $date->dayOfWeek;

            if ($schedules->where('day_of_week', $dayOfWeek)->isNotEmpty()) {
                $this->availableDays[] = $day;
            }
        }
    }

    public function selectDate($day)
    {
        $this->selectedDate = Carbon::create($this->currentYear, $this->currentMonth, $day)->toDateString();
        $this->loadAvailableTimeSlots();
    }

    public function loadAvailableTimeSlots()
    {
        $date = Carbon::parse($this->selectedDate);
        $dayOfWeek = $date->dayOfWeek;

        $schedule = $this->doctor->work_schedules->firstWhere('day_of_week', $dayOfWeek);

        if (!$schedule) {
            $this->availableTimes = [];
            return;
        }

        $start = Carbon::parse($schedule->start_time);
        $end = Carbon::parse($schedule->end_time);

        $slots = [];
        while ($start->lt($end)) {
            $slot = $start->format('H:i');

            $exists = AppointmentsBooking::where('doctor_user_id', $this->userId)
                ->where('date', $this->selectedDate)
                ->where('booking_time', $slot)
                ->exists();

            if (!$exists) {
                $slots[] = $slot;
            }

            $start->addMinutes(30);
        }

        $this->availableTimes = $slots;
    }

    public function incrementMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->calculateAvailableDays();
    }

    public function decrementMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->calculateAvailableDays();
    }

    public function render()
    {
        $daysInMonth = Carbon::create($this->currentYear, $this->currentMonth)->daysInMonth;

        return view('livewire.booking-form', [
            'daysInMonth' => $daysInMonth
        ]);
    }
}
