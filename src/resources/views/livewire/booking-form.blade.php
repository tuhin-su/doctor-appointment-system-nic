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

    @if ($selectedDate)
        <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-800 mb-2">
                Available Slots on {{ \Carbon\Carbon::parse($selectedDate)->format('D, M jS Y') }}
            </h3>

            @if (count($availableTimes) > 0)
                <div class="flex flex-wrap gap-3">
                    @foreach ($availableTimes as $time)
                        <button wire:click="bookSlot('{{ $time }}')"
                            class="px-4 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                            {{ \Carbon\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}
                        </button>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-red-500">No available time slots.</p>
            @endif
        </div>
    @endif
</div>
