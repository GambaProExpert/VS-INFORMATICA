@props(['secciones', 'enlacesSecundarios'])

@php
    $slugActual = request()->route('slug');
@endphp

{{--
    Panel lateral de móvil. Vive dentro del x-data de la cabecera, así que
    comparte el estado 'menuMovil' sin necesidad de eventos.

    Las secciones se despliegan en acordeón en vez de esconderse tras otro
    nivel de navegación: en una web de 17 páginas, enseñarlas todas es más
    rápido que hacer que la gente las busque.
--}}
<div x-show="menuMovil" x-cloak class="lg:hidden" role="dialog" aria-modal="true" aria-label="Menú">

    <div x-show="menuMovil"
         x-transition.opacity
         @click="menuMovil = false"
         class="fixed inset-0 z-40 bg-tinta/40 backdrop-blur-sm"></div>

    <div x-show="menuMovil"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         @keydown.escape.window="menuMovil = false"
         class="fixed inset-y-0 right-0 z-50 flex w-full max-w-sm flex-col border-l border-linea bg-papel">

        <div class="flex h-16 shrink-0 items-center justify-between border-b border-linea px-5">
            <span class="etiqueta text-xs text-tenue">Menú</span>
            <button type="button"
                    @click="menuMovil = false"
                    class="rounded-boton border border-linea p-2 text-tinta transition hover:bg-niebla"
                    aria-label="Cerrar el menú">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.7" stroke-linecap="round" aria-hidden="true">
                    <path d="m6 6 12 12M18 6 6 18"/>
                </svg>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto px-5 py-4" aria-label="Navegación principal">
            <ul class="space-y-1">
                @foreach ($secciones as $seccion)
                    <li>
                        @if (empty($seccion['hijos']))
                            <a href="{{ $seccion['url'] }}"
                               class="flex items-center gap-3 rounded-boton px-3 py-3 transition hover:bg-niebla">
                                <x-icono :nombre="$seccion['icono']" class="h-5 w-5 shrink-0 text-azafran"/>
                                <span class="font-display font-semibold text-tinta">{{ $seccion['nav'] }}</span>
                            </a>
                        @else
                            <div x-data="{ abierto: {{ collect($seccion['hijos'])->contains('slug', $slugActual) || $slugActual === $seccion['slug'] ? 'true' : 'false' }} }">
                                <button type="button"
                                        @click="abierto = ! abierto"
                                        :aria-expanded="abierto ? 'true' : 'false'"
                                        class="flex w-full items-center gap-3 rounded-boton px-3 py-3 text-left transition hover:bg-niebla">
                                    <x-icono :nombre="$seccion['icono']" class="h-5 w-5 shrink-0 text-azafran"/>
                                    <span class="flex-1 font-display font-semibold text-tinta">{{ $seccion['nav'] }}</span>
                                    <svg class="h-4 w-4 text-tenue transition-transform"
                                         :class="abierto && 'rotate-180'"
                                         viewBox="0 0 20 20" fill="none" stroke="currentColor"
                                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                         aria-hidden="true">
                                        <path d="m5.5 8 4.5 4.5L14.5 8"/>
                                    </svg>
                                </button>

                                <ul x-show="abierto" x-collapse class="ml-4 space-y-0.5 border-l border-linea pl-4">
                                    <li>
                                        <a href="{{ $seccion['url'] }}"
                                           class="block rounded-boton px-3 py-2 font-medium text-[11px] uppercase
                                                  tracking-wide text-tenue transition hover:bg-niebla hover:text-tinta">
                                            Ver todo · {{ $seccion['titulo'] }}
                                        </a>
                                    </li>
                                    @foreach ($seccion['hijos'] as $hijo)
                                        <li>
                                            <a href="{{ $hijo['url'] }}"
                                               @class([
                                                   'block rounded-boton px-3 py-2 text-sm transition hover:bg-niebla',
                                                   'font-medium text-tinta' => $slugActual === $hijo['slug'],
                                                   'text-tenue' => $slugActual !== $hijo['slug'],
                                               ])>{{ $hijo['nav'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>

            <hr class="my-4 border-linea">

            <ul class="space-y-1">
                @foreach ($enlacesSecundarios as $enlace)
                    <li>
                        <a href="{{ route($enlace['ruta']) }}"
                           @class([
                               'block rounded-boton px-3 py-2.5 transition hover:bg-niebla',
                               'font-medium text-tinta' => request()->routeIs($enlace['ruta']),
                               'text-tenue' => ! request()->routeIs($enlace['ruta']),
                           ])>{{ $enlace['titulo'] }}</a>
                    </li>
                @endforeach
                <li>
                    <a href="{{ route('mapa') }}" class="block rounded-boton px-3 py-2.5 text-tenue transition hover:bg-niebla">
                        Mapa del sitio
                    </a>
                </li>
            </ul>
        </nav>

        <div class="shrink-0 space-y-3 border-t border-linea px-5 py-4">
            <p class="etiqueta text-xs text-tenue">
                {{ config('empresa.horario.texto') }}
            </p>
            <x-cta-telefono class="w-full justify-center"/>
        </div>
    </div>
</div>
