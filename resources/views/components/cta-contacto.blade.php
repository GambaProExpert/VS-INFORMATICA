@props([
    'texto' => 'No lo dude, contacte con nosotros, estaremos encantados de hablar con usted',
    'boton' => 'Contacte',
])

{{--
    El cierre que remataba casi todas las páginas del sitio original. Se
    conserva su texto literal, pero ahora con dos salidas reales: el formulario
    y el teléfono. Antes solo había un enlace a una página sin formulario.
--}}
<section class="border-y border-linea bg-niebla">
    <div class="contenedor py-12 lg:py-16">
        <div data-anim class="flex flex-col items-start gap-6 lg:flex-row lg:items-center lg:justify-between">
            <p class="max-w-xl font-display text-xl font-medium text-tinta sm:text-2xl">
                {{ $texto }}
            </p>

            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('contacto') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-boton bg-azafran
                          px-5 py-3 font-medium text-sobre-azafran transition hover:bg-azafran-fuerte">
                    {{ $boton }}
                </a>

                <a href="tel:{{ config('empresa.telefono.e164') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-boton border
                          border-linea bg-papel px-5 py-3 font-sans font-semibold tabular-nums text-tinta
                          transition hover:border-linea-fuerte">
                    <x-icono nombre="telefono" class="h-4 w-4"/>
                    {{ config('empresa.telefono.legible') }}
                </a>
            </div>
        </div>
    </div>
</section>
