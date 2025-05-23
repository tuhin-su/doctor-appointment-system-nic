<div class="w-full h-full relative">
    @if (!$bookingMode)
        <div class="bg-gray-100 min-h-screen p-6">
            <!-- Search Input -->
            <div class="flex flex-col items-center space-y-4">
                <div class="flex w-full max-w-xl">
                    <input
                        type="text"
                        wire:model="search"
                        placeholder="Search doctors by name or specialty..."
                        class="flex-grow px-4 py-2 border border-gray-300 rounded-l-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    />
                    <button
                        wire:click="searchQuery"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-r-md hover:bg-indigo-700 transition"
                    >
                        Search
                    </button>
                </div>
            </div>
            
            

            <!-- Doctor Cards -->
            <div class="grid grid-cols-1 mt-4 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($users as $user)
                    @php
                        $doctor = $user->doctors->first(); // If multiple, adapt accordingly
                    @endphp
                    <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
                        <div class="p-4 flex items-center">
                            <!-- Doctor Image -->
                            <div class="w-20 h-20 bg-gray-200 rounded-full overflow-hidden">
                                <img src="{{ $user->profile_image ?? 'https://picsum.photos/200?random=' . $user->id }}"
                                    alt="Doctor Image" class="w-full h-full object-cover">
                            </div>

                            <!-- Doctor Info -->
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-800">Dr. {{ $user->name }}</h3>
                                <p class="text-sm text-indigo-600 font-medium">
                                    {{ $doctor?->specialty ?? 'Specialty not set' }}
                                </p>


                                <p class="text-xs text-gray-500">
                                    {{ $doctor?->experience_text ?? 'N/A' }} Experience
                                </p>

                                @if ($doctor?->verified_degree)
                                    <div class="flex items-center mt-1 text-green-500 text-xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Verified Degree
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="px-4 py-2 border-t">
                            <button wire:click="openBookingForm({{ $user->id }})"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-md text-sm font-medium">
                                Book Appointment
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @elseif ($bookingMode)
        <livewire:booking-form :doctorId="$doctorId" />
    @endif
</div>
