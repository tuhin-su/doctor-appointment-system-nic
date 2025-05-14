<div class="space-y-5 p-5 max-w-3xl mx-auto">
    

    @forelse ($notifications as $notification)
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all p-5 flex items-start gap-4">
            <!-- Icon -->
            <div class="flex-shrink-0 bg-blue-100 text-blue-600 rounded-full p-2">
                <i class="ri-information-line text-xl"></i>
            </div>

            <!-- Message Content -->
            <div class="flex-1">
                <p class="text-gray-700 font-medium">
                    {{ $notification->data['message'] ?? 'You have a new notification.' }}
                </p>
                <p class="text-sm text-gray-400 mt-1">
                    {{ $notification->created_at->diffForHumans() }}
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex-shrink-0">
                <button 
                    wire:click="$emit('markAsRead', '{{ $notification->id }}')" 
                    class="text-gray-400 hover:text-green-500 transition" 
                    title="Mark as read"
                >
                    <i class="ri-check-double-line text-lg"></i>
                </button>
            </div>
        </div>
    @empty
        <div class="text-center p-10 bg-white rounded-xl border border-gray-200 shadow-sm">
            <i class="ri-inbox-archive-line text-4xl text-gray-300 mb-3"></i>
            <p class="text-gray-500 text-lg">No notifications at the moment.</p>
        </div>
    @endforelse
</div>
