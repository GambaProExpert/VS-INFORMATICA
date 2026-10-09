@props(['imagenes' => [], 'titulo' => 'Galería'])

{{--
    Galería con visor.

    Las 38 capturas de a3ERP son de 1280×1024: en la rejilla se muestran
    miniaturas de 480 px con loading="lazy", y la grande solo se pide al abrir
    el visor.

    Importante: el visor pinta UNA sola <picture> apuntando al índice activo.
    Recorrer las 38 con x-for y esconderlas con x-show haría que el navegador
    descargase los 7 MB de golpe al abrir la primera — el atributo src se
    resuelve aunque el elemento esté oculto.

    El x-data va en línea a propósito: Alpine llega dentro del paquete de
    Livewire y registrarlo con Alpine.data() desde app.js llegaría tarde.
--}}
<div x-data="{
        abierta: null,
        imagenes: {{ Js::from(collect($imagenes)->map(fn ($im) => [
            'grande' => $im['grande'],
            'alt'    => $im['alt'],
        ])->values()) }},
        get actual() { return this.abierta === null ? null : this.imagenes[this.abierta] },
        abrir(i) { this.abierta = i; document.body.style.overflow = 'hidden' },
        cerrar()  { this.abierta = null; document.body.style.overflow = '' },
        mover(paso) { this.abierta = (this.abierta + paso + this.imagenes.length) % this.imagenes.length },
     }"
     @keydown.escape.window="abierta !== null && cerrar()"
     @keydown.arrow-right.window="abierta !== null && mover(1)"
     @keydown.arrow-left.window="abierta !== null && mover(-1)">

    <ul data-anim="lista" class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
        @foreach ($imagenes as $i => $imagen)
            <li>
                <button type="button"
                        @click="abrir({{ $i }})"
                        class="group block w-full overflow-hidden rounded-tarjeta border border-linea
                               bg-tarjeta transition hover:border-linea-fuerte hover:shadow-suave">
                    <img src="{{ $imagen['mini'] }}"
                         alt="{{ $imagen['alt'] }}"
                         width="480" height="384"
                         loading="lazy"
                         class="aspect-[5/4] w-full object-cover object-top transition group-hover:scale-[1.02]">
                </button>
            </li>
        @endforeach
    </ul>

    {{-- Visor --}}
    <template x-if="abierta !== null">
        <div class="fixed inset-0 z-50 flex flex-col bg-tinta/95 backdrop-blur-sm"
             role="dialog" aria-modal="true" aria-label="{{ $titulo }}">

            <div class="flex shrink-0 items-center justify-between p-4">
                <p class="etiqueta text-xs text-white/70">
                    <span x-text="abierta + 1"></span> / {{ count($imagenes) }}
                </p>
                <button type="button" @click="cerrar()"
                        class="rounded-boton border border-white/20 p-2 text-white transition hover:bg-white/10"
                        aria-label="Cerrar la galería">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.7" stroke-linecap="round" aria-hidden="true">
                        <path d="m6 6 12 12M18 6 6 18"/>
                    </svg>
                </button>
            </div>

            <div class="flex flex-1 items-center justify-center gap-2 overflow-hidden px-2 pb-4 sm:gap-4 sm:px-4">
                <button type="button" @click="mover(-1)"
                        class="shrink-0 rounded-full border border-white/20 p-2.5 text-white transition hover:bg-white/10"
                        aria-label="Imagen anterior">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m14 6-6 6 6 6"/>
                    </svg>
                </button>

                {{-- Una sola imagen en el DOM: la que se está viendo. --}}
                <img :src="actual.grande" :alt="actual.alt"
                     class="max-h-full max-w-full rounded-tarjeta object-contain shadow-2xl">

                <button type="button" @click="mover(1)"
                        class="shrink-0 rounded-full border border-white/20 p-2.5 text-white transition hover:bg-white/10"
                        aria-label="Imagen siguiente">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m10 6 6 6-6 6"/>
                    </svg>
                </button>
            </div>
        </div>
    </template>
</div>
