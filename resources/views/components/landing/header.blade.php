<header class="sticky top-0 z-50 bg-surface/70 backdrop-blur border-b border-outline">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <h1 class="font-bold text-lg tracking-wide">
            ELROI <span class="text-on-surface">Oikonomos</span>
        </h1>

        <nav class="flex items-center gap-6 text-sm text-on-surface">

            <a href="#hero" class="hover:text-on-surface-strong">Inicio</a>
            <a href="#features" class="hover:text-on-surface-strong">Características</a>
            <a href="#pricing" class="hover:text-on-surface-strong">Planes</a>

            {{-- Theme Toggle --}}
            <button id="theme-toggle" class="rounded-full p-2 border border-outline hover:bg-surface-alt transition"
                aria-label="Cambiar tema">

                {{-- Sun --}}
                <svg id="icon-sun" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364-1.414 1.414M8.05 15.95l-1.414 1.414m0-11.314L8.05 8.05m7.9 7.9 1.414 1.414M12 8a4 4 0 100 8 4 4 0 000-8z" />
                </svg>

                {{-- Moon --}}
                <svg id="icon-moon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" />
                </svg>
            </button>

            <a href="/admin" class="px-4 py-2 rounded bg-primary text-on-primary font-medium hover:bg-opacity-90">
                {{ auth()->check() ? 'Panel de Administración' : 'Iniciar Sesión' }}
            </a>
        </nav>
    </div>
</header>
