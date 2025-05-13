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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    @if (Auth::check())
        <div id="top-bar" class="fixed top-0 left-0 right-0 h-[60px] z-50 bg-white shadow-sm border-b border-blue-200">
            <livewire:top-bar />
        </div>
    @endif

    


    <div class="@if (Auth::check()) pt-[60px] @endif">
        <div class="h-[calc(100vh-60px)] overflow-y-auto">
            @yield('content')
        </div>
    </div>

    @livewireScripts
    <script src="{{ mix('js/app.js') }}" defer></script>

</body>

</html>
