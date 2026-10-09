@props([
    'titular',
    'entradilla' => null,
    'entradilla2' => null,
    'migas' => [],
])

{{--
    Cabecera de página interior. El sitio original ponía el H1 centrado y
    debajo dos líneas de reclamo; se conserva esa estructura, pero alineada a
    la izquierda para que se lea de corrido en móvil.

    Sin icono. Lo hubo, en un recuadro a la izquierda del H1, y competía con el
    titular: el ojo no sabía por dónde empezar y el titular perdía la salida a la
    izquierda, que es donde una página interior tiene que arrancar. El icono
    sigue donde hace falta —en las tarjetas y en el menú, para distinguir un
    servicio de otro de un vistazo—; en la propia página del servicio no
    distingue nada, porque solo hay uno.
--}}
<section class="border-b border-linea bg-niebla">
    <div class="contenedor py-10 lg:py-14">

        @if (! empty($migas))
            <x-migas :migas="$migas" class="mb-6"/>
        @endif

        <h1 class="font-display text-3xl font-semibold tracking-tight text-tinta sm:text-4xl lg:text-5xl">
            {{ $titular }}
        </h1>

        @if ($entradilla)
            <p class="mt-4 max-w-2xl text-lg text-tenue">
                {{ $entradilla }}
                @if ($entradilla2)
                    <br class="hidden sm:block">{{ $entradilla2 }}
                @endif
            </p>
        @endif
    </div>
</section>
