<header class="sticky top-0 z-50 bg-black/70 backdrop-blur border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-lg tracking-wide">
            ELROI <span class="text-gray-400">Oikonomos</span>
        </h1>

        <nav class="flex items-center gap-6 text-sm text-gray-300">
            <a href="#hero" class="hover:text-white transition">Inicio</a>
            <a href="#features" class="hover:text-white transition">Características</a>
            <a href="#pricing" class="hover:text-white transition">Planes</a>

            <a href="/admin"
               class="px-4 py-2 rounded bg-white text-black font-medium hover:bg-gray-200 transition">
                @if (auth()->check())
                    Panel de Administración
                @else
                    Iniciar Sesión                    
                @endif
            </a>
        </nav>
    </div>
</header>