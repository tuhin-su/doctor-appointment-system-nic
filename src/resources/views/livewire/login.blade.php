<div class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="flex w-full max-w-5xl bg-white shadow-2xl rounded-2xl overflow-hidden">
        @if (session()->has('message'))
            <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <!-- Left Image Section -->
        <div class="w-1/2 hidden md:block">
            <img src="https://images.pexels.com/photos/40568/medical-appointment-doctor-healthcare-40568.jpeg"
                alt="Doctor Illustration" class="w-full h-full object-cover" />
        </div>

        <!-- Right Form Section -->
        <div class="w-full md:w-1/2 p-10">
            <h2 class="text-4xl font-bold text-blue-700 mb-2">Welcome Back</h2>
            <p class="text-sm text-gray-600 mb-6">Doctor Appointment System Login</p>

            <!-- Login Form -->
            <form wire:submit.prevent="login" class="space-y-5">
                <!-- Email Input -->
                <div>
                    <label for="email" class="block mb-1 text-gray-700 font-medium">Email</label>
                    <input wire:model="email" type="email" id="email" placeholder="Enter your email"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('email') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <label for="passwd" class="block mb-1 text-gray-700 font-medium">Password</label>
                    <input wire:model="passwd" type="password" id="passwd" placeholder="Enter your password"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('passwd') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex justify-between items-center">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" class="mr-2" id="remember" /> Remember me
                    </label>
                    <a href="#" class="text-sm text-blue-500 hover:underline">Forgot password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition duration-300">
                    Sign In
                </button>
            </form>

            <!-- Sign Up Link -->
            <p class="mt-6 text-sm text-center text-gray-600">
                Don't have an account?
                <a href="/register" class="text-blue-500 hover:underline">Sign up</a>
            </p>
        </div>
    </div>
</div>
