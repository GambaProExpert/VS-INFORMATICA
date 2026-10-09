@props(['servicio', 'conImagen' => false])

<a href="{{ $servicio['url'] }}"
   {{ $attributes->class([
       'group flex flex-col overflow-hidden rounded-tarjeta border border-linea bg-tarjeta',
       'transition hover:border-linea-fuerte hover:shadow-suave',
   ]) }}>

    @if ($conImagen && $servicio['imagen'])
        <img src="{{ asset($servicio['imagen']) }}"
             alt="{{ $servicio['imagen_alt'] }}"
             width="400" height="225"
             loading="lazy"
             class="aspect-video w-full border-b border-linea object-cover">
    @endif

    <div class="flex flex-1 flex-col p-6">
        <x-icono :nombre="$servicio['icono']" class="h-8 w-8 text-azafran"/>

        <h3 class="mt-4 font-display text-xl font-semibold text-tinta">
            {{ $servicio['titulo'] }}
        </h3>

        <p class="mt-2 flex-1 text-[15px] leading-relaxed text-tenue">
            {{ $servicio['sumario'] }}
        </p>

        <span class="mt-5 inline-flex items-center gap-1.5 font-medium text-sm text-azafran-oscuro">
            Ver más
            <x-icono nombre="flecha" class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5"/>
        </span>
    </div>
</a>
