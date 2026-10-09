@props(['titulo' => 'Partners oficiales'])

{{--
    Los seis logos que ya salían en el pie del sitio original. Van en escala de
    grises y recuperan el color al pasar por encima: así no compiten con el
    ámbar de las llamadas a la acción, que es la regla de tres apariciones por
    pantalla.
--}}
<div {{ $attributes->class(['border-b border-linea']) }}>
    <div class="contenedor py-8">
        <p class="text-center etiqueta text-[11px] text-tenue">
            {{ $titulo }}
        </p>

        <ul data-anim="lista" class="mt-6 flex flex-wrap items-center justify-center gap-x-10 gap-y-6 sm:gap-x-14"
            x-data="partnersLogos()">
            @foreach (config('empresa.partners') as $partner)
                <li class="h-7 flex items-center">
                    <img :src="oscuro ? '{{ asset('images/partners/' . $partner['logo_oscuro']) }}' : '{{ asset('images/partners/' . $partner['logo_claro']) }}'"
                         alt="{{ $partner['nombre'] }}"
                         loading="lazy"
                         class="h-full w-auto max-w-xs opacity-60 transition hover:opacity-100 object-contain">
                </li>
            @endforeach
        </ul>
    </div>
</div>
