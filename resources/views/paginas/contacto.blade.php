@php
    $empresa = config('empresa');
    $direccion = $empresa['direccion'];
    $direccionCompleta = "{$direccion['calle']}, {$direccion['cp']} {$direccion['localidad']}, {$direccion['provincia']}";
@endphp

<x-layouts.base
    titulo="Contacto"
    descripcion="Estamos en C/ Puerta de Granada, 39, La Roda (Albacete). Llámanos al 967 44 51 53.">

    <x-cabecera-pagina
        titular="Contacto"
        entradilla="Para cualquier duda o sugerencia puede llamarnos en horario de oficina."
        entradilla2="Le atenderemos encantado."
        :migas="[
            ['titulo' => 'Inicio', 'url' => route('home')],
            ['titulo' => 'Contacto', 'url' => null],
        ]"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-[1fr_22rem] lg:gap-16 items-stretch">

            {{-- ===== Datos de la oficina (izquierda, más ancho) ===== --}}
            <div class="space-y-6 lg:col-span-1 lg:col-start-1">

                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6 lg:p-8">
                    <h2 class="font-display text-xl font-semibold text-tinta">Datos de contacto</h2>

                    <dl class="mt-6 space-y-5">
                        <div class="flex items-start gap-3">
                            <x-icono nombre="telefono" class="mt-1 h-5 w-5 shrink-0 text-azafran"/>
                            <div>
                                <p class="etiqueta text-[11px] text-tenue">Teléfono</p>
                                <a href="tel:{{ $empresa['telefono']['e164'] }}"
                                   class="mt-1 font-sans text-2xl font-semibold tabular-nums text-tinta transition hover:text-azafran-oscuro">
                                    {{ $empresa['telefono']['legible'] }}
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <x-icono nombre="sobre" class="mt-1 h-5 w-5 shrink-0 text-azafran"/>
                            <div>
                                <p class="etiqueta text-[11px] text-tenue">Email</p>
                                <a href="mailto:{{ $empresa['email'] }}"
                                   class="mt-1 text-tenue transition hover:text-tinta">
                                    {{ $empresa['email'] }}
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <x-icono nombre="mapa" class="mt-1 h-5 w-5 shrink-0 text-azafran"/>
                            <div>
                                <p class="etiqueta text-[11px] text-tenue">Dirección</p>
                                <address class="mt-1 not-italic text-tenue">
                                    <p>{{ $direccion['calle'] }}</p>
                                    <p>{{ $direccion['cp'] }} {{ $direccion['localidad'] }} ({{ $direccion['provincia'] }})</p>
                                </address>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <x-icono nombre="reloj" class="mt-1 h-5 w-5 shrink-0 text-azafran"/>
                            <div>
                                <p class="etiqueta text-[11px] text-tenue">Horario</p>
                                <p class="mt-1 text-tenue">{{ $empresa['horario']['texto'] }}</p>
                            </div>
                        </div>
                    </dl>
                </div>

                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6 lg:p-8">
                    <h2 class="font-display text-xl font-semibold text-tinta">¿Es una avería urgente?</h2>
                    <p class="mt-2 text-sm text-tenue">
                        Descarga el cliente de soporte remoto y llámanos: muchas incidencias se
                        resuelven en la misma llamada, sin moverte de tu sitio.
                    </p>
                    <a href="{{ route('soporte') }}"
                       class="mt-4 inline-flex items-center justify-center gap-2 rounded-boton
                             border border-linea px-4 py-2.5 text-sm font-medium text-tinta
                             transition hover:border-linea-fuerte">
                        <x-icono nombre="descarga" class="h-4 w-4"/>
                        Soporte remoto
                    </a>
                </div>
            </div>

            {{-- ===== Mapa (derecha) ===== --}}
            <aside class="lg:col-span-1 lg:col-start-2 flex flex-col">
                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6 flex flex-col flex-1">
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
                    <div x-data="{ mapa: false }" class="mt-4 flex-1 flex flex-col">
                        <template x-if="! mapa">
                            <button type="button"
                                    @click="mapa = true"
                                    class="flex w-full flex-col items-center justify-center gap-2
                                           rounded-boton border border-dashed border-linea-fuerte
                                           bg-niebla px-4 py-8 text-center transition hover:bg-papel flex-1">
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
                                class="h-full w-full rounded-boton border border-linea flex-1"></iframe>
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
            </aside>
        </div>
    </div>

</x-layouts.base>
