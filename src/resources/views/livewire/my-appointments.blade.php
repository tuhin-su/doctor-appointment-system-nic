<div class="p-6 max-w-4xl mx-auto bg-white rounded shadow">
    <!-- Month Navigation -->
    <h2 class="text-2xl font-semibold mb-4">
        {{ \Carbon\Carbon::create($currentYear, $currentMonth)->format('F Y') }}
    </h2>

    <div class="flex justify-between mb-4">
        <button wire:click="decrementMonth" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">← Previous</button>
        <button wire:click="incrementMonth" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Next →</button>
    </div>

    <!-- Days of the Week -->
    <div class="grid grid-cols-7 gap-2 text-center font-semibold text-gray-700 mb-2">
        @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
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
                $isAvailable = in_array($day, $availableDays);
                $isSelected = $selectedDate && \Carbon\Carbon::parse($selectedDate)->day == $day;
            @endphp

            <button wire:click="selectDate({{ $day }})"
                class="w-full aspect-square rounded-md border text-sm
                    {{ $isAvailable ? 'bg-green-100 hover:bg-green-200 text-black' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}
                    {{ $isSelected ? 'border-indigo-500 ring-2 ring-indigo-300' : '' }}"
                {{ $isAvailable ? '' : 'disabled' }}>
                {{ $day }}
            </button>
        @endfor
    </div>

    <!-- Appointments for selected date -->
    @if ($selectedDate)
        <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-800 mb-2">
                Appointments on {{ \Carbon\Carbon::parse($selectedDate)->format('D, M jS Y') }}
            </h3>

            @if ($selectedAppointments->count() > 0)
                <div class="space-y-4">
                    @foreach ($selectedAppointments as $appointment)
                        <div class="bg-gray-100 p-4 rounded shadow">
                            <p><strong>Doctor:</strong> {{ $appointment->doctor->user->name }}</p>
                            <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->booking_time)->format('g:i A') }}</p>
                            <button wire:click="cancelAppointment({{ $appointment->id }})" class="mt-2 px-4 py-2 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                                Cancel Appointment
                            </button>
                            <!-- Reschedule Button -->
                            {{-- <button wire:click="openRescheduleModal({{ $appointment->id }})" class="mt-2 px-4 py-2 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">
                                Reschedule Appointment
                            </button> --}}
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-red-500">No appointments for this date.</p>
            @endif
        </div>
    @endif

    <!-- Reschedule Modal -->
    @if ($showRescheduleModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <h3 class="text-xl font-semibold mb-4">Reschedule Appointment</h3>
                <form wire:submit.prevent="rescheduleAppointment">
                    <div class="mb-4">
                        <label for="newDate" class="block text-sm font-medium text-gray-700">New Date</label>
                        <input type="date" id="newDate" wire:model="newDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="newTime" class="block text-sm font-medium text-gray-700">New Time</label>
                        <input type="time" id="newTime" wire:model="newTime" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Save</button>
                        <button wire:click="closeRescheduleModal" type="button" class="ml-2 px-4 py-2 bg-gray-200 text-black rounded-md">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
