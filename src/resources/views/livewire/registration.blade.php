<div class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="flex w-full max-w-5xl bg-white shadow-2xl rounded-2xl overflow-hidden">
    <!-- Left Image Section -->
    <div class="w-1/2 hidden md:block">
      <img
        src="https://images.unsplash.com/photo-1478476868527-002ae3f3e159?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
        alt="Doctor Illustration"
        class="w-full h-full object-cover"
      />
    </div>

    <!-- Right Form Section -->
    <div class="w-full md:w-1/2 p-10">
      <h2 class="text-4xl font-bold text-blue-700 mb-2">Create Your Account</h2>
      <p class="text-sm text-gray-600 mb-6">Doctor Appointment System Registration</p>


      <form wire:submit.prevent="register" class="space-y-5">
        <div>
          <label class="block mb-1 text-gray-700 font-medium">Full Name</label>
          <input type="text" wire:model="name" placeholder="Enter your full name"
            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
          <label class="block mb-1 text-gray-700 font-medium">Email</label>
          <input type="email" wire:model="email" placeholder="Enter your email"
            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
          <label class="block mb-1 text-gray-700 font-medium">Password</label>
          <input type="password" wire:model="passwd" placeholder="Enter your password"
            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          @error('passwd') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
          <label class="block mb-1 text-gray-700 font-medium">Confirm Password</label>
          <input type="password" wire:model="passwd_confirmation" placeholder="Confirm your password"
            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          @error('passwd_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-between items-center">
          <label class="flex items-center text-sm text-gray-600">
            <input type="checkbox" class="mr-2" /> Agree to Terms & Conditions
          </label>
        </div>

        <button
          type="submit"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition duration-300">
          Sign Up
        </button>
      </form>

      <p class="mt-6 text-sm text-center text-gray-600">
        Already have an account?
        <a href="/login" class="text-blue-500 hover:underline">Log in</a>
      </p>
    </div>
  </div>
</div>
