<div class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="flex w-full max-w-4xl bg-white shadow-xl rounded-2xl overflow-hidden">
      <div class="w-full p-10">
          <h2 class="text-4xl font-bold text-blue-700 mb-4">Profile Settings</h2>
          <p class="text-sm text-gray-600 mb-8">Update your profile information below</p>

         

          <form wire:submit.prevent="save" class="space-y-6">

              <!-- Profile Picture Section -->
              <div class="flex items-center space-x-6 mb-6">
                  <div class="w-20 h-20 rounded-full bg-gray-200 overflow-hidden">
                      @if (is_object($profile_image))
                          <img src="{{ $profile_image->temporaryUrl() }}"
                               class="w-full h-full object-cover" />
                      @else
                          <img src="{{ $profile_image }}"
                               class="w-full h-full object-cover" />
                      @endif
                  </div>
                  <input type="file" wire:model="profile_image"
                         class="text-sm text-gray-700" accept="image/*" />
              </div>

              <!-- Full Name -->
              <div>
                  <label class="block mb-1 text-gray-700 font-medium">Full Name</label>
                  <input type="text" wire:model="name"
                         class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500" />
                  @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
              </div>

              <!-- Email -->
              <div>
                  <label class="block mb-1 text-gray-700 font-medium">Email</label>
                  <input type="email" wire:model="email"
                         class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500" />
                  @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
              </div>

              <!-- New Password -->
              <div>
                  <label class="block mb-1 text-gray-700 font-medium">New Password</label>
                  <input type="password" wire:model="password"
                         class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500" />
                  @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
              </div>

              <!-- Confirm Password -->
              <div>
                  <label class="block mb-1 text-gray-700 font-medium">Confirm Password</label>
                  <input type="password" wire:model="confirm_password"
                         class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500" />
                  @error('confirm_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
              </div>

              <!-- Save Button -->
              <button type="submit"
                      class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition duration-300">
                  Save Changes
              </button>
          </form>

          <!-- Cancel Link -->
          <p class="mt-6 text-sm text-center text-gray-600">
              <a href="/dashboard" class="text-blue-500 hover:underline">Cancel</a>
          </p>
      </div>
  </div>
</div>
