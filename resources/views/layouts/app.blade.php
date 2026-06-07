<!DOCTYPE html>
<html class="@yield('htmlClass', 'light')" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
        </script>
    </body>
</html>
