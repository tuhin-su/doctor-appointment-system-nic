<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Appointment a Doctor | @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://unpkg.com/@iconify/iconify-icon"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="flex w-full h-screen">
        @if (Auth::check())
            {{-- Sidebar shown only if user is logged in --}}
            <div class="h-full w-[250px] relative overflow-hidden">
                <livewire:side-bar />
            </div>

            <div class="absolute top-0 left-[250px] right-0 bottom-0">
                <main class="h-full w-full relative p-4 overflow-auto">
                    @yield('content')
                </main>
            </div>
        @else
            {{-- Full width if user is not logged in --}}
            <div class="w-full h-full">
                <main class="h-full w-full relative p-4 overflow-auto">
                    @yield('content')
                </main>
            </div>
        @endif
    </div>

    @livewireScripts
</body>


</html>
