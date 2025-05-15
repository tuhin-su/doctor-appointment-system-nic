<div class="w-full h-full pt-5">
    <div class="mb-6 flex space-x-2 px-4">
        <input
            type="text"
            wire:model.defer="search"
            placeholder="Search doctors by name or email..."
            class="flex-grow px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            autocomplete="off"
        >
        <button
            wire:click="searchDoctors"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow"
            type="button"
        >
            Search
        </button>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
        @if (!$modify)
            @foreach ($allDoctor as $user)
                @php
                    $doctor = $user->doctors->first(); // If multiple, adapt accordingly
                @endphp
                <div class="bg-white shadow rounded-lg m-4 overflow-hidden border border-gray-200">
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
                        <button wire:click="openSchedule({{ $user->id }})"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-md text-sm font-medium">
                            Manage Schedule
                        </button>
                    </div>
                </div>
            @endforeach
        @else
        {{-- take fill grid screen --}}
            <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200 h-screen w-screen">
                @livewire('doctor-appointment', ['userId' => $doctorId])
            </div>
        @endif
    </div>
    
</div>