<div class="bg-gradient-to-br from-gray-100 to-white min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl sm:text-4xl font-bold text-center text-blue-800 mb-8">
            <i class="ri-calendar-check-line text-blue-600 mr-2"></i>Doctor Work Schedule
        </h1>

        @if($successMessage)
            <div class="bg-green-100 text-green-800 border border-green-300 p-4 rounded-lg mb-6 text-center shadow-sm">
                <strong class="mr-1">Success:</strong> {{ $successMessage }}
            </div>
        @endif

        <form wire:submit.prevent="saveSchedule" class="space-y-6">
            @foreach($workSchedules as $day => $schedule)
                <div class="bg-white p-6 rounded-2xl shadow-md border border-blue-100 hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="ri-sun-line text-yellow-500 mr-2"></i>{{ $day }}
                        </h2>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="workSchedules.{{ $day }}.enabled" class="form-checkbox h-5 w-5 text-blue-600 transition">
                            <span class="ml-2 text-sm text-gray-700">Available</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600 font-medium mb-1">Start Time</label>
                            <div class="relative">
                                <i class="ri-time-line absolute top-2.5 left-3 text-gray-400"></i>
                                <input 
                                    type="time" 
                                    wire:model="workSchedules.{{ $day }}.start_time" 
                                    class="pl-10 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    {{ $schedule['enabled'] ? '' : '' }}>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 font-medium mb-1">End Time</label>
                            <div class="relative">
                                <i class="ri-time-line absolute top-2.5 left-3 text-gray-400"></i>
                                <input 
                                    type="time" 
                                    wire:model="workSchedules.{{ $day }}.end_time" 
                                    class="pl-10 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    {{ $schedule['enabled'] ? '' : '' }}>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 font-medium mb-1">Break Start</label>
                            <div class="relative">
                                <i class="ri-time-line absolute top-2.5 left-3 text-gray-400"></i>
                                <input 
                                    type="time" 
                                    wire:model="workSchedules.{{ $day }}.break_start" 
                                    class="pl-10 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    {{ $schedule['enabled'] ? '' : '' }}>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 font-medium mb-1">Break End</label>
                            <div class="relative">
                                <i class="ri-time-line absolute top-2.5 left-3 text-gray-400"></i>
                                <input 
                                    type="time" 
                                    wire:model="workSchedules.{{ $day }}.break_end" 
                                    class="pl-10 w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    {{ $schedule['enabled'] ? '' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="text-center pt-6">
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-full shadow-lg hover:bg-blue-700 transition inline-flex items-center">
                    <i class="ri-save-line mr-2 text-xl"></i>Save Schedule
                </button>
            </div>
        </form>
    </div>
</div>
