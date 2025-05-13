<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Doctor</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Icons & Scripts -->
    <script src="https://unpkg.com/@iconify/iconify-icon"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    @if (Auth::check())
        <div id="top-bar" class="fixed top-0 left-0 right-0 h-[60px] z-50 bg-white shadow-sm border-b border-blue-200">
            <livewire:top-bar />
        </div>
    @endif

    <div x-data="{ show: false, message: '', type: '' }" x-init="@if (session()->has('messages')) let messages = @json(session()->get('messages'));
            let latest = messages[messages.length - 1];
            message = latest.message;
            type = latest.type;
            show = true;
            setTimeout(() => show = false, 5000); @endif" x-show="show" x-transition
        class="fixed bottom-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg text-white"
        :class="{
            'bg-green-500': type === 'success',
            'bg-red-500': type === 'error',
            'bg-blue-500': type === 'info',
            'bg-yellow-500': type === 'warning'
        }">
        <span x-text="message"></span>
    </div>


    <div class="@if (Auth::check()) pt-[60px] @endif">
        <div class="h-[calc(100vh-60px)] overflow-y-auto">
            @yield('content')
        </div>
    </div>

    @livewireScripts
    <script src="{{ mix('js/app.js') }}" defer></script>

</body>

</html>
