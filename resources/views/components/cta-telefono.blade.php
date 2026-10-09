{{--
    Teléfono como enlace tel: de verdad, no como imagen ni como texto suelto.
    En un móvil es un toque para llamar, y para VS Informática el teléfono
    sigue siendo el canal principal.

    Hubo una variante `compacto` que en pantallas pequeñas dejaba solo el icono:
    era para la cabecera, donde a 390 px no caben logotipo, número, selector de
    tema y menú. La cabecera ya no lleva teléfono, así que la variante se ha ido
    con ella. Si alguna vez vuelve a hacer falta esconderlo desde fuera, ojo:
    $attributes->class() fusiona las clases, de modo que el `inline-flex` de aquí
    y un `hidden` de quien invoca acaban en el mismo elemento y gana el que
    Tailwind emita después. Se resuelve dentro del componente, no con clases
    de fuera.
--}}
<a href="tel:{{ config('empresa.telefono.e164') }}"
   aria-label="Llamar a {{ config('empresa.nombre_largo') }}, {{ config('empresa.telefono.legible') }}"
   {{ $attributes->class([
       'inline-flex items-center justify-center gap-2 rounded-boton bg-azafran px-4 py-2.5',
       'font-sans text-sm font-semibold tabular-nums text-sobre-azafran transition',
       'hover:bg-azafran-fuerte',
   ]) }}>
    <x-icono nombre="telefono" class="h-4 w-4 shrink-0"/>
    <span class="whitespace-nowrap">{{ config('empresa.telefono.legible') }}</span>
</a>
