<footer class="reveal border-t border-outline bg-surface-alt">
    <div class="max-w-7xl mx-auto px-6 py-12">

        <div class="flex flex-col md:flex-row justify-between gap-8">

            {{-- Brand --}}
            <div>
                <h4 class="font-bold text-lg">
                    ELROI <span class="text-on-surface">Oikonomos</span>
                </h4>
                <p class="text-sm text-on-surface mt-2 max-w-sm">
                    Sistema de mayordomía digital para administrar fielmente
                    clientes, proyectos y tareas.
                </p>
            </div>

            {{-- Links --}}
            <div class="flex gap-12 text-sm">
                <div>
                    <p class="font-semibold mb-2">Producto</p>
                    <ul class="space-y-1 text-on-surface">
                        <li><a href="#features" class="hover:text-on-surface-strong">Características</a></li>
                        <li><a href="#" class="hover:text-on-surface-strong">Planes</a></li>
                    </ul>
                </div>

                <div>
                    <p class="font-semibold mb-2">Acceso</p>
                    <ul class="space-y-1 text-on-surface">
                        @if (auth()->check())
                            <li><a href="{{ route('filament.admin.pages.dashboard') }}" class="hover:text-on-surface-strong">Panel de Control</a></li>
                        @else
                            <li><a href="{{ route('filament.admin.auth.login') }}" class="hover:text-on-surface-strong">Iniciar Sesión</a></li>
                            <li><a href="{{ route('filament.admin.auth.register') }}" class="hover:text-on-surface-strong">Registrarse</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        {{-- Bottom --}}
        <div class="mt-10 pt-6 border-t border-outline text-xs text-on-surface flex justify-between">
            <span>© {{ date('Y') }} <span><a href="https://elroi.cloud" target="_blank" class="hover:text-on-surface-strong">ELROI</a></span> Oikonomos</span>
            <span>Hecho con propósito</span>
            <span>powered by <a href="https://labs.elroi.cloud" target="_blank" class="hover:text-on-surface-strong">ELROI Labs</a></span>
        </div>
    </div>
</footer>
