<div class="bg-gray-100 min-h-screen flex items-center justify-center">

    <!-- Main Container -->
    <div class="flex w-full max-w-4xl bg-white shadow-xl rounded-2xl overflow-hidden">
      
      <!-- Right Form Section -->
      <div class="w-full p-10">
  
        <!-- Profile Heading -->
        <h2 class="text-4xl font-bold text-blue-700 mb-4">Profile Settings</h2>
        <p class="text-sm text-gray-600 mb-8">Update your profile information below</p>
  
        <form class="space-y-6">
          
          <!-- Profile Picture Section -->
          <div class="flex items-center space-x-6 mb-6">
            <div class="w-20 h-20 rounded-full bg-gray-200 overflow-hidden">
              <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile Picture"
                class="w-full h-full object-cover" />
            </div>
            <button type="button" class="text-sm text-blue-500 hover:underline">Change Profile Picture</button>
          </div>
  
          <!-- Full Name Section -->
          <div>
            <label class="block mb-1 text-gray-700 font-medium">Full Name</label>
            <input type="text" placeholder="Enter your full name"
              class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>
  
          <!-- Email Section -->
          <div>
            <label class="block mb-1 text-gray-700 font-medium">Email</label>
            <input type="email" placeholder="Enter your email"
              class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>
  
          <!-- New Password Section -->
          <div>
            <label class="block mb-1 text-gray-700 font-medium">New Password</label>
            <input type="password" placeholder="Enter your new password"
              class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>
  
          <!-- Confirm Password Section -->
          <div>
            <label class="block mb-1 text-gray-700 font-medium">Confirm New Password</label>
            <input type="password" placeholder="Confirm your new password"
              class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>
  
          <!-- Save Changes Button -->
          <button
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