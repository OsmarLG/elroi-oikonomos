<footer class="reveal border-t border-white/10 bg-black">
    <div class="max-w-7xl mx-auto px-6 py-12">

        <div class="flex flex-col md:flex-row justify-between gap-8">

            {{-- Brand --}}
            <div>
                <h4 class="font-bold text-lg">
                    ELROI <span class="text-gray-400">Oikonomos</span>
                </h4>
                <p class="text-sm text-gray-400 mt-2 max-w-sm">
                    Sistema de mayordomía digital para administrar fielmente
                    clientes, proyectos y tareas.
                </p>
            </div>

            {{-- Links --}}
            <div class="flex gap-12 text-sm">
                <div>
                    <p class="font-semibold mb-2">Producto</p>
                    <ul class="space-y-1 text-gray-400">
                        <li><a href="#features" class="hover:text-white">Características</a></li>
                        <li><a href="#" class="hover:text-white">Planes</a></li>
                    </ul>
                </div>

                <div>
                    <p class="font-semibold mb-2">Acceso</p>
                    <ul class="space-y-1 text-gray-400">
                        @if (auth()->check())
                            <li><a href="{{ route('filament.admin.pages.dashboard') }}" class="hover:text-white">Panel de Control</a></li>
                        @else
                            <li><a href="{{ route('filament.admin.auth.login') }}" class="hover:text-white">Iniciar Sesión</a></li>
                            <li><a href="{{ route('filament.admin.auth.register') }}" class="hover:text-white">Registrarse</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        {{-- Bottom --}}
        <div class="mt-10 pt-6 border-t border-white/10 text-xs text-gray-500 flex justify-between">
            <span>© {{ date('Y') }} <span><a href="https://elroi.com" target="_blank" class="hover:text-white">ELROI</a></span> Oikonomos</span>
            <span>Hecho con propósito</span>
            <span>powered by <a href="https://studio.elroi.com" target="_blank" class="hover:text-white">ELROI Studio</a></span>
        </div>
    </div>
</footer>
