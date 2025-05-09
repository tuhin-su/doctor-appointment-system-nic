<nav class="bg-gray-800 z-50" x-data="{ mobileMenuOpen: false }">
  <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
    <div class="relative flex h-16 items-center justify-between">

      <!-- Mobile menu button -->
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <button @click="mobileMenuOpen = !mobileMenuOpen"
                type="button"
                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-inset focus:ring-white"
                aria-controls="mobile-menu"
                :aria-expanded="mobileMenuOpen.toString()">
          <span class="sr-only">Open main menu</span>
          <i x-show="!mobileMenuOpen" class="ri-menu-line"></i>
          <i x-show="mobileMenuOpen" class="ri-close-large-line"></i>
        </button>
      </div>

      <!-- Logo and Desktop menu -->
      <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
        <div class="hidden sm:ml-6 sm:block">
          <div class="flex space-x-4 items-center">
            @foreach ($menu as $index => $item)
              @if (!isset($item['roles']) || in_array(Auth::user()->role, $item['roles']))
                @if (isset($item['children']))
                  <!-- Dropdown item -->
                  <div class="relative" x-data="{ isOpen: false }">
                    <button type="button"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white rounded-md focus:outline-none"
                            @click="isOpen = !isOpen; $event.stopPropagation()">
                      <i class="{{ $item['icon'] }} {{ $item['icon_color'] }} mr-1"></i>
                      {{ $item['title'] }}
                      <svg class="ml-1 h-4 w-4" 
                           :class="{ 'transform rotate-180': isOpen }"
                           fill="currentColor" 
                           viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.14.976l-4.25 4.657a.75.75 0 01-1.1 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                      </svg>
                    </button>

                    <!-- Submenu dropdown -->
                    <div x-show="isOpen"
                         x-cloak
                         @click.outside="isOpen = false"
                         class="absolute z-10 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black/5 focus:outline-none"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95">
                      <div class="py-1">
                        @foreach ($item['children'] as $child)
                          @if (in_array(Auth::user()->role, $child['roles']))
                            <a href="{{ $child['route'] }}"
                               @click="isOpen = false"
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                              <i class="{{ $child['icon'] }} {{ $child['icon_color'] }} mr-2"></i> {{ $child['title'] }}
                            </a>
                          @endif
                        @endforeach
                      </div>
                    </div>
                  </div>
                @else
                  <a href="{{ $item['route'] }}"
                     class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="{{ $item['icon'] }} {{ $item['icon_color'] }} mr-1"></i> {{ $item['title'] }}
                  </a>
                @endif
              @endif
            @endforeach
          </div>
        </div>
      </div>

      <!-- Profile menu -->
      <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
        <div class="relative" x-data="{ open: false }">
          <button @click="open = !open"
                  type="button"
                  class="rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:ring-2 focus:ring-offset-2 focus:ring-white">
            <span class="sr-only">Open user menu</span>
            <img class="size-8 rounded-full border-solid border-2 border-blue-500 p-1"
                 src="{{ Auth::user()->profile_image ?? 'https://picsum.photos/200?random=1' }}" alt="">
          </button>
          <div x-show="open"
               @click.away="open = false"
               x-cloak
               class="absolute right-0 z-10 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black/5">
            <a href="/profile" class="block px-4 py-2 text-sm text-gray-700">Your Profile</a>
            <a href="/settings" class="block px-4 py-2 text-sm text-gray-700">Settings</a>
            @csrf
            <div>
              <a href="/logout"
                  class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  Sign out
            </a>
          </div>
          
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile menu -->
  <div class="sm:hidden" id="mobile-menu" x-show="mobileMenuOpen" x-cloak>
    <div class="space-y-1 px-2 pt-2 pb-3">
      @foreach ($menu as $item)
        @if (!isset($item['roles']) || in_array(Auth::user()->role, $item['roles']))
          @if (isset($item['children']))
            <div class="border-t border-gray-700">
              <div class="px-3 py-2 text-sm font-medium text-gray-400">{{ $item['title'] }}</div>
              @foreach ($item['children'] as $child)
                @if (in_array(Auth::user()->role, $child['roles']))
                  <a href="{{ $child['route'] }}"
                     class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="{{ $child['icon'] }} {{ $child['icon_color'] }} mr-1"></i> {{ $child['title'] }}
                  </a>
                @endif
              @endforeach
            </div>
          @else
            <a href="{{ $item['route'] }}"
               class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
              <i class="{{ $item['icon'] }} {{ $item['icon_color'] }} mr-1"></i> {{ $item['title'] }}
            </a>
          @endif
        @endif
      @endforeach
    </div>
  </div>
</nav>
