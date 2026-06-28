<!DOCTYPE html>
<html class="@yield('htmlClass', 'light')" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', config('app.name', 'EduMentor'))</title>
        @fonts
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body class="@yield('bodyClass', 'min-h-screen bg-background font-body-md text-on-background antialiased')">
        @yield('body')

        @stack('scripts')
        <script>
            document.querySelectorAll('[data-password-toggle]').forEach((button) => {
                button.addEventListener('click', () => {
                    const input = document.getElementById(button.dataset.passwordToggle);

                    if (!input) {
                        return;
                    }

                    const nextType = input.type === 'password' ? 'text' : 'password';

                    input.type = nextType;
                    button.querySelector('.material-symbols-outlined').textContent = nextType === 'password' ? 'visibility' : 'visibility_off';
                });
            });

            // Mobile Sidebar Toggle
            document.addEventListener('DOMContentLoaded', () => {
                const sidebar = document.getElementById('admin-sidebar');
                const sidebarToggle = document.getElementById('sidebar-toggle');
                const sidebarBackdrop = document.getElementById('sidebar-backdrop');

                if (sidebar && sidebarToggle) {
                    const toggleSidebar = () => {
                        const isOpen = !sidebar.classList.contains('-translate-x-full');
                        if (isOpen) {
                            sidebar.classList.add('-translate-x-full');
                            if (sidebarBackdrop) sidebarBackdrop.classList.add('hidden');
                        } else {
                            sidebar.classList.remove('-translate-x-full');
                            if (sidebarBackdrop) sidebarBackdrop.classList.remove('hidden');
                        }
                    };

                    sidebarToggle.addEventListener('click', toggleSidebar);
                    if (sidebarBackdrop) {
                        sidebarBackdrop.addEventListener('click', toggleSidebar);
                    }
                }
            });
        </script>
    </body>
</html>
