<div class="w-full p-6">
    @if ($viewMode)
        <div class="mb-6 flex space-x-2">
            <input type="text" wire:model.defer="search" placeholder="Search by name, email, or role..."
                class="flex-grow px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                autocomplete="off">
            <button wire:click="searchUsers"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow" type="button">
                Search
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($users as $user)
                <div
                    class="bg-white rounded-2xl shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-300 p-5 flex flex-col items-center text-center">

                    <!-- Avatar -->
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow mb-4">
                        <img src="{{ $user->profile_image ?? 'https://picsum.photos/200?random=1' }}"
                            alt="{{ $user->name }}'s Avatar" class="w-full h-full object-cover">
                    </div>

                    <!-- Role Badge -->
                    <span class="bg-indigo-500 text-white text-xs font-semibold px-3 py-1 rounded-full mb-2 capitalize">
                        {{ $user->role }}
                    </span>

                    <!-- Name and Email -->
                    <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>

                    <!-- Joined Info -->
                    <div class="text-sm text-gray-400 mt-2 flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-500 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 4h10M5 11h14M5 15h14M5 19h14"></path>
                        </svg>
                        Joined {{ $user->created_at->diffForHumans() }}
                    </div>

                    <!-- Edit Button -->
                    <button wire:click="openEditForm({{ $user->id }})"
                        class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2 px-6 rounded-full transition-all duration-300">
                        Edit Profile
                    </button>
                </div>
            @endforeach
        </div>
    @else
        @if ($user)
            <div class="min-h-screen flex items-center justify-center bg-gray-100">
                <div
                    class="w-full max-w-5xl bg-white rounded-2xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-3">

                    <!-- Profile Sidebar -->
                    <div
                        class="bg-gradient-to-br from-indigo-600 to-indigo-800 text-white flex flex-col items-center justify-center p-6">
                        <img src="{{ $user->profile_image ?? 'https://picsum.photos/200?random=1' }}"
                            alt="Profile Image" class="w-28 h-28 rounded-full border-4 border-white shadow mb-4">
                        <h3 class="text-lg font-semibold">{{ $user->name }}</h3>
                        <p class="text-sm text-indigo-200">Profile Image (Read Only)</p>
                    </div>

                    <!-- Form Area -->
                    <div class="col-span-2 p-6 sm:p-10">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit User Information</h2>
                        <form wire:submit.prevent="saveUser" class="space-y-5">

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input id="name" type="text" wire:model.lazy="name"
                                    class="w-full mt-1 px-4 py-2 border rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('user.name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input id="email" type="email" wire:model="email"
                                    class="w-full mt-1 px-4 py-2 border rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('user.email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>

                                <select id="role" wire:model="role" wire:change="roleChanged"
                                    class="w-full mt-1 px-4 py-2 border rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Select role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Doctor">Doctor</option>
                                    <option value="Patient">Patient</option>
                                </select>

                                @error('role')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>


                            <!-- Doctor Fields -->
                            @if ($role === 'Doctor')
                                <div class="pt-4 border-t border-gray-300 mt-6">
                                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Doctor Details</h3>

                                    <!-- Specialty -->
                                    <div>
                                        <label for="specialty"
                                            class="block text-sm font-medium text-gray-700">Specialty</label>
                                        <input id="specialty" type="text" wire:model="specialty"
                                            class="w-full mt-1 px-4 py-2 border rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        @error('specialty')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Verified Degree -->
                                    <div class="flex items-center mt-4">
                                        <input type="checkbox" id="verified_degree" wire:model="verified_degree"
                                            class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="verified_degree" class="ml-2 text-sm text-gray-700">Verified
                                            Degree</label>
                                    </div>

                                    <!-- Job Start Date -->
                                    <div class="mt-4">
                                        <label for="job_started" class="block text-sm font-medium text-gray-700">Job
                                            Start Date</label>
                                        <input id="job_started" type="date" wire:model="job_started"
                                            class="w-full mt-1 px-4 py-2 border rounded-lg shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        @error('job_started')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <!-- Submit Button -->
                            <div class="pt-6">
                                <button type="submit"
                                    class="w-full md:w-auto px-6 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow focus:ring-4 focus:ring-indigo-300">
                                    Save Changes
                                </button>

                                <button type="button" wire:click="closeEditForm"
                                    class="w-full md:w-auto px-6 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow focus:ring-4 focus:ring-indigo-300">
                                    Cancel
                                </button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
