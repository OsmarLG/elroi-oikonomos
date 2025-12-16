<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ELROI Oikonomos') }}</title>

    {{-- Prevent FOUC --}}
    <script>
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const theme = savedTheme ?? (prefersDark ? 'dark' : 'light');
        document.documentElement.setAttribute('data-theme', theme);
    </script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen antialiased">

    @yield('content')

    {{-- Theme Toggle Script --}}
    <script>
        const root = document.documentElement
        const toggle = document.getElementById('theme-toggle')
        const sun = document.getElementById('icon-sun')
        const moon = document.getElementById('icon-moon')

        function applyTheme(theme) {
            root.setAttribute('data-theme', theme)
            localStorage.setItem('theme', theme)

            if (theme === 'dark') {
                moon.classList.remove('hidden')
                sun.classList.add('hidden')
            } else {
                sun.classList.remove('hidden')
                moon.classList.add('hidden')
            }
        }

        // Init
        applyTheme(root.getAttribute('data-theme'))

        toggle?.addEventListener('click', () => {
            const current = root.getAttribute('data-theme')
            applyTheme(current === 'dark' ? 'light' : 'dark')
        })
    </script>
</body>
</html>
