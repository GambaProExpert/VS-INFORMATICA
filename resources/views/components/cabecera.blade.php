@php
    use App\Contenido\Servicios;

    $secciones = Servicios::secciones();
    $slugActual = request()->route('slug');

    // Una sección está activa si estamos en ella o en cualquiera de sus hijos.
    $esActiva = function (array $seccion) use ($slugActual): bool {
        if ($slugActual === null) {
            return false;
        }

        return $slugActual === $seccion['slug']
            || collect($seccion['hijos'])->contains('slug', $slugActual);
    };

    $enlacesSecundarios = [
        ['titulo' => 'Empresa',  'ruta' => 'empresa'],
        ['titulo' => 'Soporte',  'ruta' => 'soporte'],
        ['titulo' => 'Contacto', 'ruta' => 'contacto'],
    ];
@endphp

<header x-data="cabecera()" class="sticky top-0 z-40">

    {{-- Franja superior: enlaces secundarios y selector de tema.
         Se esconde en móvil, donde el espacio vale más.

         Aquí no va el horario. Primero hubo una barra de estado que los sábados
         anunciaba "FIN DE SEMANA · DÉJANOS TU INCIDENCIA" —lo primero que leía
         quien entraba era que no había nadie—; luego quedó el horario a secas, y
         también se ha retirado. Un dato que no cambia nunca no necesita estar en
         todas las páginas por encima del logotipo. Sigue publicado donde se
         busca: en Contacto, en el pie, en la home y en el menú de móvil. --}}
    <div class="hidden border-b border-linea bg-niebla lg:block">
        <div class="contenedor flex h-10 items-center justify-end">
            <nav aria-label="Enlaces secundarios" class="flex items-center gap-6">
                @foreach ($enlacesSecundarios as $enlace)
                    <a href="{{ route($enlace['ruta']) }}"
                       @class([
                           'text-sm transition hover:text-tinta',
                           'text-tinta font-medium' => request()->routeIs($enlace['ruta']),
                           'text-tenue' => ! request()->routeIs($enlace['ruta']),
                       ])>{{ $enlace['titulo'] }}</a>
                @endforeach

                <x-selector-tema />
            </nav>
        </div>
    </div>

    {{-- Barra principal --}}
    <div class="border-b border-linea bg-papel/85 backdrop-blur-md">
        <div class="contenedor flex h-16 items-center justify-between gap-4 lg:h-20">

            <a href="{{ route('home') }}" class="shrink-0" aria-label="{{ config('empresa.nombre_largo') }} — Inicio">
                <img :src="oscuro ? '{{ asset('images/marca/logo_oscuro.png') }}' : '{{ asset('images/marca/logo_claro.png') }}'"
                     alt="{{ config('empresa.nombre_largo') }}"
                     width="180" height="180"
                     class="h-8 w-auto lg:h-12">
            </a>

            {{-- Navegación de escritorio: las 4 secciones del sitio original --}}
            <nav aria-label="Servicios" class="hidden items-center lg:flex">
                @foreach ($secciones as $seccion)
                    @if (empty($seccion['hijos']))
                        {{-- Software no tiene subpáginas: enlace directo --}}
                        <a href="{{ $seccion['url'] }}"
                           @class([
                               'group flex flex-col rounded-boton px-3 py-2 transition hover:bg-niebla',
                               'bg-niebla' => $esActiva($seccion),
                           ])>
                            <span class="font-display text-[15px] font-semibold leading-tight text-tinta">
                                {{ $seccion['nav'] }}
                            </span>
                            <span class="etiqueta text-[10px] text-tenue">
                                {{ $seccion['nav_subtitulo'] }}
                            </span>
                        </a>
                    @else
                        <div x-data="{ abierto: false }"
                             @mouseenter="abierto = true"
                             @mouseleave="abierto = false"
                             @keydown.escape.window="abierto = false"
                             class="relative">

                            <button type="button"
                                    @click="abierto = ! abierto"
                                    :aria-expanded="abierto ? 'true' : 'false'"
                                    @class([
                                        'group flex items-center gap-1.5 rounded-boton px-3 py-2 text-left transition hover:bg-niebla',
                                        'bg-niebla' => $esActiva($seccion),
                                    ])>
                                <span class="flex flex-col">
                                    <span class="font-display text-[15px] font-semibold leading-tight text-tinta">
                                        {{ $seccion['nav'] }}
                                    </span>
                                    <span class="etiqueta text-[10px] text-tenue">
                                        {{ $seccion['nav_subtitulo'] }}
                                    </span>
                                </span>
                                <svg class="h-3.5 w-3.5 shrink-0 text-tenue transition-transform"
                                     :class="abierto && 'rotate-180'"
                                     viewBox="0 0 20 20" fill="none" stroke="currentColor"
                                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                     aria-hidden="true">
                                    <path d="m5.5 8 4.5 4.5L14.5 8"/>
                                </svg>
                            </button>

                            <div x-show="abierto"
                                 x-cloak
                                 x-transition.opacity.duration.150ms
                                 class="absolute left-0 top-full w-72 pt-2">
                                <div class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta shadow-suave">
                                    <a href="{{ $seccion['url'] }}"
                                       class="flex items-center gap-2 border-b border-linea px-4 py-3
                                              etiqueta text-[11px] text-tenue
                                              transition hover:bg-niebla hover:text-tinta">
                                        Ver todo · {{ $seccion['titulo'] }}
                                    </a>

                                    @foreach ($seccion['hijos'] as $hijo)
                                        <a href="{{ $hijo['url'] }}"
                                           @class([
                                               'flex items-start gap-3 px-4 py-3 transition hover:bg-niebla',
                                               'bg-niebla' => $slugActual === $hijo['slug'],
                                           ])>
                                            <x-icono :nombre="$hijo['icono']" class="mt-0.5 h-5 w-5 shrink-0 text-azafran"/>
                                            <span>
                                                <span class="block text-sm font-medium text-tinta">{{ $hijo['nav'] }}</span>
                                                <span class="mt-0.5 block text-xs leading-snug text-tenue">{{ $hijo['entradilla'] }}</span>
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </nav>

            {{-- Grupo de móvil: selector de tema y menú. En escritorio no queda
                 nada a la derecha —el teléfono estaba aquí y se ha retirado—, así
                 que el bloque entero desaparece y la navegación queda enrasada al
                 borde en vez de flotar contra un hueco vacío. --}}
            <div class="flex items-center gap-2 lg:hidden">
                <x-selector-tema />

                <button type="button"
                        @click="menuMovil = true"
                        class="rounded-boton border border-linea p-2 text-tinta transition hover:bg-niebla"
                        aria-label="Abrir el menú">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.7" stroke-linecap="round" aria-hidden="true">
                        <path d="M4 7h16M4 12h16M4 17h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <x-menu-movil :secciones="$secciones" :enlaces-secundarios="$enlacesSecundarios"/>
</header>
