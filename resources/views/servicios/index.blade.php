<x-layouts.base
    titulo="Servicios de informática para empresas en La Roda y Albacete"
    descripcion="Todo lo que hacemos en VS Informática: a3ERP, servidores y redes, seguridad,
                 reparación con taller propio, servicios cloud, equipos a medida y consumibles.">

    <x-cabecera-pagina
        titular="Servicios"
        entradilla="Todo lo que tu empresa necesita, en la misma casa."
        entradilla2="Desde el ERP hasta el cartucho de tinta."
        :migas="[
            ['titulo' => 'Inicio', 'url' => route('home')],
            ['titulo' => 'Servicios', 'url' => null],
        ]"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="space-y-16">
            @foreach ($secciones as $seccion)
                <section>
                    <div class="flex flex-col gap-4 border-b border-linea pb-5 sm:flex-row sm:items-end sm:justify-between">
                        <div class="flex items-start gap-4">
                            <span class="mt-0.5 shrink-0 rounded-tarjeta border border-linea bg-tarjeta p-2.5">
                                <x-icono :nombre="$seccion['icono']" class="h-6 w-6 text-azafran"/>
                            </span>
                            <div>
                                <h2 class="font-display text-2xl font-semibold tracking-tight text-tinta">
                                    <a href="{{ $seccion['url'] }}" class="transition hover:text-azafran-oscuro">
                                        {{ $seccion['titulo'] }}
                                    </a>
                                </h2>
                                <p class="mt-1 text-tenue">
                                    {{ $seccion['entradilla'] }}
                                    {{ $seccion['entradilla_2'] }}
                                </p>
                            </div>
                        </div>

                        <a href="{{ $seccion['url'] }}"
                           class="shrink-0 font-medium text-sm text-azafran-oscuro underline-offset-4 hover:underline">
                            Ver la sección
                        </a>
                    </div>

                    @if (empty($seccion['hijos']))
                        <ul data-anim="lista" class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            <li class="flex">
                                <x-tarjeta-servicio :servicio="$seccion" class="flex-1"/>
                            </li>
                        </ul>
                    @else
                        <ul data-anim="lista" class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($seccion['hijos'] as $hijo)
                                <li class="flex">
                                    <x-tarjeta-servicio :servicio="$hijo" class="flex-1"/>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </section>
            @endforeach
        </div>
    </div>

    <x-cta-contacto />

</x-layouts.base>
