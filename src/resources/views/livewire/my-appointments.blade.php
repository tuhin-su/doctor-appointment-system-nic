<div class="mt-6 relative max-w-4xl mx-auto">
    <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
        <i class="ri-calendar-event-line text-blue-500 text-3xl"></i>
        Your Appointments
    </h2>

    <!-- Appointments -->
    @if ($appointments->count() > 0)
        <div class="space-y-4">
            @foreach ($appointments as $appointment)
                <div
                    class="flex items-start justify-between bg-gray-50 hover:bg-gray-100 transition p-5 rounded-xl border border-gray-200 shadow-sm">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <i class="ri-stethoscope-line text-gray-500 text-xl"></i>
                            <p class="text-gray-700 font-medium">
                                Dr. {{ $appointment->doctor->user->name }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="ri-calendar-event-line text-blue-400 text-lg"></i>
                            <span class="text-sm text-gray-600 font-medium">
                                {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}
                            </span>

                            <i class="ri-time-line text-gray-400 text-lg ml-4"></i>
                            <span class="text-sm text-gray-600 font-medium">
                                {{ \Carbon\Carbon::parse($appointment->booking_time)->format('g:i A') }}
                            </span>
                        </div>

                    </div>

                    <div class="flex gap-2">
                        <!-- Cancel Button -->
                        <button wire:click="cancelAppointment({{ $appointment->id }})"
                            class="bg-red-100 text-red-600 hover:bg-red-200 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-1 transition">
                            <i class="ri-close-line"></i> Cancel
                        </button>

                        <!-- Reschedule Button -->
                        <button wire:click="rescheduleAppointment({{ $appointment->id }})"
                            class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-1 transition">
                            <i class="ri-calendar-check-line"></i> Reschedule
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center p-6 bg-white border rounded-xl text-gray-500">
            <i class="ri-calendar-x-line text-4xl mb-2 text-gray-300"></i>
            <p>No appointments booked.</p>
        </div>
    @endif

    <!-- Reschedule Modal -->
    @if ($rescheduling)
        @livewire('booking-form', ['appointment' => $rescheduling])
    @endif
</div>
