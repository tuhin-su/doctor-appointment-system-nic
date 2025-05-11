<div class="bg-gray-100">

    <!-- Full-screen Doctor Gallery -->
    <div class="w-full h-screen p-6 overflow-y-auto">
        <!-- Search Input -->
        <div class="flex justify-center mb-6">
            <input type="text" placeholder="Search doctors by name or specialty..."
                class="w-full max-w-2xl px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                id="doctorSearchInput" />
        </div>

        <!-- Flexbox Container for Doctor Cards -->
        <div id="doctorCardsContainer" class="flex flex-wrap gap-3 justify-center w-full">
            <!-- Doctor 1 Card -->
            @foreach ($users as $user)
                @php
                    $doctor = $user->doctors->first(); // Get the first doctor record (if any)
                @endphp
                <div
                    class="doctor-card w-full sm:w-1/2 md:w-1/3 lg:w-1/3 xl:w-1/3 2xl:w-1/4 bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                    <div class="flex p-4">
                        <!-- Doctor Image -->
                        <div class="w-32 h-32 bg-gray-200 rounded-full overflow-hidden">
                            <img src="{{ $user->profile_image ?? 'https://picsum.photos/200?random=' . $user->id }}"
                                alt="Doctor Image" class="w-full h-full object-cover">
                        </div>
                        <!-- Doctor Info -->
                        <div class="ml-4 flex flex-col justify-between">
                            <h3 class="text-xl font-semibold text-gray-800 doctor-name">Dr. {{ $user->name }}</h3>
                            <p class="text-sm text-gray-500 doctor-specialty">
                                MD, {{ $doctor?->specialty ?? 'N/A' }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ $doctor ? now()->diffInYears($doctor->job_started) : 0 }}+ Years of Experience
                            </p>

                            <!-- Degree Verification Icon -->
                            @if ($doctor?->verified_degree)
                                <div class="flex items-center mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="w-5 h-5 text-green-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <p class="text-xs text-gray-500 ml-1">Verified Degree</p>
                                </div>
                            @endif

                            <!-- Sitting Time -->
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Sitting Time: <span class="text-indigo-600">10:00 AM -
                                        2:00 PM</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info: Doctor ID & Specialty -->
                    <div class="p-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">Doctor ID:
                                <span class="font-semibold text-gray-800">#{{ $doctor?->id ?? 'N/A' }}</span>
                            </span>
                            <span class="text-xs text-gray-500">Specialty:
                                <span class="font-semibold text-gray-800">{{ $doctor?->specialty ?? 'N/A' }}</span>
                            </span>
                        </div>
                        <button
                            class="w-full py-2 mt-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Book Appointment
                        </button>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
