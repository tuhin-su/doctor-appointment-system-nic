<div class="p-4 sm:p-6 max-w-7xl mx-auto">
    @if (!$rescheduleBookingView)
        <h1 class="text-2xl font-bold mb-4 text-gray-800">All Bookings</h1>

        {{-- Search Input --}}
        <div class="mb-6">
            <input type="text" wire:model.debounce.500ms="search" placeholder="Search by patient, doctor, or date..."
                class="w-full p-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" />
        </div>

        {{-- Table View for Desktop --}}
        <div class="hidden md:block bg-white shadow rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Patient</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Doctor</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Time</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($bookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $booking->patientUser->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $booking->doctorUser->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $booking->date->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $booking->booking_time->format('H:i') }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">{{ $booking->reschedule_status }}</span>
                            </td>
                            <td class="flex justify-space-between gap-2 items-center px-6 py-4">
                                @if ($booking->reschedule_status !== 'cancelled')
                                    <button wire:click="rescheduleBooking({{ $booking->id }})"
                                        class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-1 transition">Reschedule</button>
                                    <button wire:click="cancelBooking({{ $booking->id }})"
                                        class="bg-red-100 text-red-600 hover:bg-red-200 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-1 transition">Cancel</button>
                                @else
                                    <span class="text-sm text-gray-400 italic">No actions available</span>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Card View for Mobile/Tablet --}}
        <div class="md:hidden space-y-4">
            @forelse ($bookings as $booking)
                <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="text-sm text-gray-500">Patient</div>
                    <div class="text-base font-medium text-gray-800 mb-1">{{ $booking->patientUser->name ?? 'N/A' }}
                    </div>

                    <div class="text-sm text-gray-500">Doctor</div>
                    <div class="text-base font-medium text-gray-800 mb-1">{{ $booking->doctorUser->name ?? 'N/A' }}
                    </div>

                    <div class="flex justify-between items-center mt-2 text-sm text-gray-600">
                        <div><strong>Date:</strong> {{ $booking->date->format('Y-m-d') }}</div>
                        <div><strong>Time:</strong> {{ $booking->booking_time->format('H:i') }}</div>
                    </div>

                    <div class="mt-3 flex w-full justify-space-between gap-3">
                        @if ($booking->reschedule_status)
                            <span
                                class="inline-block px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                        @else
                            <span
                                class="inline-block px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Confirmed</span>
                        @endif

                        @if ($booking->reschedule_status !== 'cancelled')
                            <button wire:click="rescheduleBooking({{ $booking->id }})"
                                class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-1 transition">Reschedule</button>
                            <button wire:click="cancelBooking({{ $booking->id }})"
                                class="bg-red-100 text-red-600 hover:bg-red-200 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-1 transition">Cancel</button>
                        @else
                            <span class="text-sm text-gray-400 italic">No actions available</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500">No bookings found.</div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $bookings->links('pagination::tailwind') }}
        </div>
    @else
        @livewire('reschedule-appointment-form', ['appointmentId' => $rescheduleBookingId])
    @endif
</div>
