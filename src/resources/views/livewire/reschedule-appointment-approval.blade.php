<div class="space-y-4">
    @forelse ($pendingAppointments as $appointment)
        <div
            class="flex flex-col md:flex-row md:items-center justify-between bg-white p-5 rounded-xl border border-gray-200 shadow hover:shadow-md transition">
            <div class="space-y-3">
                <div class="flex items-center gap-2 text-gray-700">
                    <i class="ri-user-line text-green-500 text-xl"></i>
                    <span class="font-medium">Patient:</span>
                    <span>{{ $appointment->patientUser->name ?? 'N/A' }} requested a reschedule</span>
                </div>

                <div class="flex items-center gap-2 text-gray-700">
                    <i class="ri-stethoscope-line text-blue-500 text-xl"></i>
                    <span class="font-medium">Doctor:</span>
                    <span>Dr. {{ $appointment->doctorUser->name ?? 'N/A' }}</span>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-4 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <i class="ri-calendar-event-line text-blue-400 text-lg"></i>
                        <span class="font-medium">Current:</span>
                        <span>{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }} @ {{ \Carbon\Carbon::parse($appointment->booking_time)->format('g:i A') }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <i class="ri-arrow-right-line text-gray-400 text-xl"></i>
                    </div>

                    <div class="flex items-center gap-2">
                        <i class="ri-calendar-check-line text-yellow-500 text-lg"></i>
                        <span class="font-medium">Requested:</span>
                        <span>{{ \Carbon\Carbon::parse($appointment->reschedule_date)->format('M d, Y') }} @ {{ \Carbon\Carbon::parse($appointment->reschedule_time)->format('g:i A') }}</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-2 mt-4 md:mt-0">
                <button wire:click="approve({{ $appointment->id }})"
                    class="bg-green-100 text-green-700 hover:bg-green-200 px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-1 transition">
                    <i class="ri-check-line"></i> Approve
                </button>

                <button wire:click="reject({{ $appointment->id }})"
                    class="bg-red-100 text-red-600 hover:bg-red-200 px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-1 transition">
                    <i class="ri-close-line"></i> Reject
                </button>
            </div>
        </div>
    @empty
        <div class="text-center p-6 bg-white border rounded-xl text-gray-500">
            <i class="ri-time-line text-4xl mb-2 text-gray-300"></i>
            <p>No pending reschedule requests.</p>
        </div>
    @endforelse
</div>
