<div class="p-6 max-w-4xl mx-auto bg-white rounded shadow">
    <h2 class="text-2xl font-semibold mb-4">
        {{ \Carbon\Carbon::create($currentYear, $currentMonth)->format('F Y') }}
    </h2>

    <div class="flex justify-between mb-4">
        <button wire:click="decrementMonth" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">← Previous</button>
        <button wire:click="incrementMonth" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Next →</button>
    </div>

    <!-- Days of the Week -->
    <div class="grid grid-cols-7 gap-2 text-center font-semibold text-gray-700 mb-2">
        @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
            <div>{{ $dayName }}</div>
        @endforeach
    </div>

    <!-- Calendar Days -->
    <div class="grid grid-cols-7 gap-2">
        @php
            $firstDayOfMonth = \Carbon\Carbon::create($currentYear, $currentMonth, 1);
            $startDayOfWeek = $firstDayOfMonth->dayOfWeek;
        @endphp

        <!-- Empty boxes before the month starts -->
        @for ($i = 0; $i < $startDayOfWeek; $i++)
            <div></div>
        @endfor

        <!-- Calendar Days -->
        @for ($day = 1; $day <= $daysInMonth; $day++)
            @php
                $date = \Carbon\Carbon::create($currentYear, $currentMonth, $day)->toDateString();
                $appointmentsForDay = $appointments->filter(function ($appointment) use ($date) {
                    return \Carbon\Carbon::parse($appointment->date)->toDateString() === $date;
                });
                $hasBooking = $appointmentsForDay->isNotEmpty();
                $isSelected = $selectedDate === $date;
            @endphp

            @if ($hasBooking)
                <button wire:click="selectDate({{ $day }})"
                    class="w-full aspect-square rounded-md border text-sm font-medium
                           bg-blue-100 hover:bg-blue-200 text-black
                           {{ $isSelected ? 'border-indigo-500 ring-2 ring-indigo-300' : '' }}">
                    {{ $day }}
                </button>
            @else
                <div
                    class="w-full aspect-square rounded-md bg-gray-100 text-gray-400 text-sm flex items-center justify-center">
                    {{ $day }}
                </div>
            @endif
        @endfor
    </div>

    @if ($selectedDate)
        <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-800 mb-2">
                Appointments on {{ \Carbon\Carbon::parse($selectedDate)->format('D, M jS Y') }}
            </h3>

            @if ($appointmentsForSelectedDate->isNotEmpty())
                <div class="flex flex-wrap gap-3">
                    @foreach ($appointmentsForSelectedDate as $appointment)
                        <div class="border rounded p-3 bg-white shadow">
                            <p><strong>Time:</strong>
                                {{ \Carbon\Carbon::parse($appointment->booking_time)->format('g:i A') }}</p>
                            <p><strong>Patient:</strong> {{ $appointment->user->name }}</p>

                            <div class="mt-2 flex gap-2">
                                <button wire:click="cancelAppointment({{ $appointment->id }})"
                                    class="px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                    Cancel
                                </button>
                                <button wire:click="rescheduleAppointment({{ $appointment->id }})"
                                    class="px-4 py-2 bg-yellow-600 text-white text-sm rounded hover:bg-yellow-700">
                                    Reschedule
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500">No appointments on this day.</p>
            @endif
        </div>
    @endif
</div>