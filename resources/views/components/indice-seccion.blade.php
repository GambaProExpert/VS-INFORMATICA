@props(['seccion'])

{{--
    Índice de una sección: la rejilla de subpáginas.

    Las tres secciones con hijos (Hardware, Cloud, Otros Servicios) tenían en
    el sitio original exactamente esta estructura — un titular, dos líneas de
    reclamo y la lista de sus páginas —, así que comparten componente en vez
    de repetirse tres veces.
--}}
<section class="contenedor py-14 lg:py-20">
    <ul data-anim="lista" class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($seccion['hijos'] as $hijo)
            <li class="flex">
                <x-tarjeta-servicio :servicio="$hijo" class="flex-1"/>
            </li>
        @endforeach
    </ul>

    {{ $slot ?? '' }}
</section>
