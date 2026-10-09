@php
    $empresa = config('empresa');
    $direccion = $empresa['direccion'];
    $direccionCompleta = "{$direccion['calle']}, {$direccion['cp']} {$direccion['localidad']}, {$direccion['provincia']}";
@endphp

<x-layouts.base
    titulo="Contacto"
    descripcion="Estamos en C/ Puerta de Granada, 39, La Roda (Albacete). Llámanos al 967 44 51 53
                 o cuéntanos qué necesitas y te llamamos nosotros.">

    <x-cabecera-pagina
        titular="Contacto"
        entradilla="Para cualquier duda o sugerencia puede llamarnos en horario de oficina."
        entradilla2="Le atenderemos encantado."
        :migas="[
            ['titulo' => 'Inicio', 'url' => route('home')],
            ['titulo' => 'Contacto', 'url' => null],
        ]"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-[1fr_22rem] lg:gap-16">

            {{-- ===== Formulario =====
                 La novedad de esta renovación: el sitio anterior no tenía
                 ninguno, y fuera de horario no había forma de dejar recado. --}}
            <div>
                <h2 class="font-display text-2xl font-semibold tracking-tight text-tinta">
                    Cuéntanos qué necesitas
                </h2>
                <p class="mt-2 max-w-xl text-tenue">
                    Rellena estos cinco campos y te llamamos nosotros. Si prefieres el teléfono,
                    también estamos ahí.
                </p>

                <div class="mt-8">
                    <livewire:formulario-contacto />
                </div>
            </div>

            {{-- ===== Datos de la oficina ===== --}}
            <aside class="space-y-4">

                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                    <p class="etiqueta text-[11px] text-tenue">Oficina La Roda</p>

                    <a href="tel:{{ $empresa['telefono']['e164'] }}"
                       class="mt-2 flex items-center gap-2.5 font-sans text-2xl font-semibold tabular-nums
                              text-tinta transition hover:text-azafran-oscuro">
                        <x-icono nombre="telefono" class="h-5 w-5 text-azafran"/>
                        {{ $empresa['telefono']['legible'] }}
                    </a>

                    <a href="mailto:{{ $empresa['email'] }}"
                       class="mt-3 flex items-center gap-2.5 text-sm text-tenue transition hover:text-tinta">
                        <x-icono nombre="sobre" class="h-4 w-4 shrink-0"/>
                        {{ $empresa['email'] }}
                    </a>

                    <hr class="my-5 border-linea">

                    <p class="etiqueta text-[11px] text-tenue">Horario</p>
                    <p class="mt-2 text-sm text-tinta">{{ $empresa['horario']['texto'] }}</p>
                </div>

                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                    <h2 class="font-display font-semibold text-tinta">Cómo llegar a nuestra tienda</h2>

                    <address class="mt-3 space-y-0.5 not-italic text-sm text-tenue">
                        <p>{{ $direccion['calle'] }}</p>
                        <p>{{ $direccion['cp'] }} {{ $direccion['localidad'] }} ({{ $direccion['provincia'] }})</p>
                    </address>

                    {{--
                        El mapa NO se embebe de entrada. Un iframe de Google
                        Maps carga scripts y cookies de terceros antes de que
                        nadie haya consentido nada, y cuesta cientos de KB en
                        una página que la mayoría abre para ver un teléfono.
                        Se carga solo si se pide.
                    --}}
                    <div x-data="{ mapa: false }" class="mt-4">
                        <template x-if="! mapa">
                            <button type="button"
                                    @click="mapa = true"
                                    class="flex w-full flex-col items-center justify-center gap-2
                                           rounded-boton border border-dashed border-linea-fuerte
                                           bg-niebla px-4 py-8 text-center transition hover:bg-papel">
                                <x-icono nombre="mapa" class="h-6 w-6 text-azafran"/>
                                <span class="text-sm font-medium text-tinta">Ver el mapa</span>
                                <span class="text-xs text-tenue">
                                    Se carga desde Google Maps solo si pulsas aquí
                                </span>
                            </button>
                        </template>

                        <template x-if="mapa">
                            <iframe
                                src="https://www.google.es/maps/d/embed?mid=1qnrgykmRJfzbA_ZMmzBipxYP0E8"
                                title="Ubicación de VS Informática en La Roda"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                class="h-72 w-full rounded-boton border border-linea"></iframe>
                        </template>
                    </div>

                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($direccionCompleta) }}"
                       target="_blank" rel="noopener noreferrer"
                       class="mt-3 inline-flex items-center gap-1.5 font-medium text-sm text-azafran-oscuro
                              underline-offset-4 hover:underline">
                        Abrir en Google Maps
                        <x-icono nombre="flecha" class="h-3.5 w-3.5"/>
                    </a>
                </div>

                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                    <h2 class="font-display font-semibold text-tinta">¿Es una avería urgente?</h2>
                    <p class="mt-2 text-sm text-tenue">
                        Descarga el cliente de soporte remoto y llámanos: muchas incidencias se
                        resuelven en la misma llamada, sin moverte de tu sitio.
                    </p>
                    <a href="{{ route('soporte') }}"
                       class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-boton
                              border border-linea px-4 py-2.5 text-sm font-medium text-tinta
                              transition hover:border-linea-fuerte">
                        <x-icono nombre="descarga" class="h-4 w-4"/>
                        Soporte remoto
                    </a>
                </div>
            </aside>
        </div>
    </div>

</x-layouts.base>
