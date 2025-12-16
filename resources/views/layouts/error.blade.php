
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center pt-8 sm:pt-0">
                <div class="px-4 text-5xl font-bold text-gray-400 border-r border-gray-500 tracking-wider">
                    @yield('code')
                </div>

                <div class="ml-4 text-2xl text-gray-500 uppercase tracking-wider">
                    @yield('message')
                </div>
            </div>
            <div class="mt-8 text-lg text-gray-400">
                @auth
                    <p>Serás redirigido al dashboard en <span id="countdown-auth">10</span> segundos.</p>
                    <a href="{{ route('filament.admin.pages.dashboard') }}" class="text-blue-500 hover:underline">O haz clic aquí para ir ahora.</a>
                    <script>
                        let countdownAuthElement = document.getElementById('countdown-auth');
                        if (countdownAuthElement) {
                            let seconds = 10;
                            const interval = setInterval(() => {
                                seconds--;
                                countdownAuthElement.textContent = seconds;
                                if (seconds <= 0) {
                                    clearInterval(interval);
                                    window.location.href = "{{ route('filament.admin.pages.dashboard') }}";
                                }
                            }, 1000);
                        }
                    </script>
                @else
                    <p>Serás redirigido a la página de inicio en <span id="countdown">10</span> segundos.</p>
                    <a href="/" class="text-blue-500 hover:underline">O haz clic aquí para ir ahora.</a>
                    <script>
                        let countdownElement = document.getElementById('countdown');
                        if (countdownElement) {
                            let seconds = 10;
                            const interval = setInterval(() => {
                                seconds--;
                                countdownElement.textContent = seconds;
                                if (seconds <= 0) {
                                    clearInterval(interval);
                                    window.location.href = '/';
                                }
                            }, 1000);
                        }
                    </script>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>
