<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard - Apotek Sehat' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="h-full bg-gray-50 font-sans antialiased">
    <div class="h-full flex flex-col">

        <x-layouts.header />

        <div class="flex flex-1 min-h-0">

            <x-layouts.sidebar />

            <main class="flex-1 min-h-0 p-4 lg:p-6 overflow-auto">
                @isset($header)
                <div class="mb-6">
                    {{ $header }}
                </div>
                @endisset
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('-translate-x-full');
                    if (sidebarOverlay) sidebarOverlay.classList.toggle('hidden');
                });

                if (sidebarOverlay) {
                    sidebarOverlay.addEventListener('click', () => {
                        sidebar.classList.add('-translate-x-full');
                        sidebarOverlay.classList.add('hidden');
                    });
                }
            }

            const mobileLinks = document.querySelectorAll('#sidebar a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        sidebar.classList.add('-translate-x-full');
                        if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
                    }
                });
            });

            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdown = document.getElementById('user-dropdown');

            if (userMenuButton && userDropdown) {
                userMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', (e) => {
                    if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
