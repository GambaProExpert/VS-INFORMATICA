@php
    use App\Contenido\Servicios;

    $secciones = Servicios::secciones();
@endphp

<x-layouts.base
    titulo="Mapa del sitio"
    descripcion="Todas las páginas de vsinformatica.es en una sola lista.">

    <x-cabecera-pagina
        titular="Mapa del sitio"
        entradilla="Todas las páginas de la web, en una lista."
        :migas="[
            ['titulo' => 'Inicio', 'url' => route('home')],
            ['titulo' => 'Mapa del sitio', 'url' => null],
        ]"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3">

            <div>
                <h2 class="font-display text-lg font-semibold text-tinta">General</h2>
                <ul class="mt-3 space-y-2">
                    <li><a href="{{ route('home') }}" class="text-tenue transition hover:text-tinta">Inicio</a></li>
                    <li><a href="{{ route('servicios.index') }}" class="text-tenue transition hover:text-tinta">Servicios</a></li>
                    <li><a href="{{ route('empresa') }}" class="text-tenue transition hover:text-tinta">Empresa</a></li>
                    <li><a href="{{ route('soporte') }}" class="text-tenue transition hover:text-tinta">Soporte remoto</a></li>
                    <li><a href="{{ route('contacto') }}" class="text-tenue transition hover:text-tinta">Contacto</a></li>
                    <li><a href="{{ route('mapa') }}" class="text-tenue transition hover:text-tinta">Mapa del sitio</a></li>
                </ul>
            </div>

            @foreach ($secciones as $seccion)
                <div>
                    <h2 class="font-display text-lg font-semibold text-tinta">
                        <a href="{{ $seccion['url'] }}" class="transition hover:text-azafran-oscuro">
                            {{ $seccion['nav'] }}
                        </a>
                    </h2>
                    @if (! empty($seccion['hijos']))
                        <ul class="mt-3 space-y-2">
                            @foreach ($seccion['hijos'] as $hijo)
                                <li>
                                    <a href="{{ $hijo['url'] }}"
                                       class="text-tenue transition hover:text-tinta">{{ $hijo['nav'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach

            <div>
                <h2 class="font-display text-lg font-semibold text-tinta">Legal</h2>
                <ul class="mt-3 space-y-2">
                    <li><a href="{{ route('legal.aviso') }}" class="text-tenue transition hover:text-tinta">Aviso legal</a></li>
                    <li><a href="{{ route('legal.privacidad') }}" class="text-tenue transition hover:text-tinta">Política de privacidad</a></li>
                    <li><a href="{{ route('legal.cookies') }}" class="text-tenue transition hover:text-tinta">Política de cookies</a></li>
                </ul>
            </div>
        </div>
    </div>

</x-layouts.base>
