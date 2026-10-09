<x-layouts.base :titulo="$servicio['meta_titulo']" :descripcion="$servicio['meta_descripcion']">

    <x-cabecera-pagina
        :titular="$servicio['titular']"
        :entradilla="$servicio['entradilla']"
        :entradilla2="$servicio['entradilla_2']"
        :migas="$migas"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-[1fr_20rem]">

            <div class="prosa">
                <h2>Infraestructura que no falla</h2>

                <p>
                    Tu empresa nunca para, por ello ofrecemos servicios hardware de más alto nivel.
                    Servidores, redes, seguridad y reparación con taller propio en La Roda.
                </p>

                <p>
                    Si tu servidor se para, estamos ahí. Montamos y mantenemos la infraestructura
                    que sostiene tu negocio: armarios de red, servidores Windows Server, redes
                    estructuradas e interconexión de sucursales por VPN.
                </p>

                <p>
                    Hardware de calidad, software bien configurado y programación profesional.
                    Los tres pilares para que la tecnología sea una herramienta, no un problema.
                </p>
            </div>

            <aside class="space-y-4 lg:pt-2">
                <figure class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta">
                    <img src="{{ asset('images/servicios/cloud.jpg') }}"
                         alt="Armario de red montado por VS Informática"
                         width="244" height="241" loading="lazy"
                         class="w-full object-cover">
                </figure>

                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                    <p class="etiqueta text-[11px] text-tenue">Lo que montamos</p>
                    <ul class="mt-4 space-y-3 text-sm text-tinta">
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="servidor" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Servidores Windows Server
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="red" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Redes estructuradas y switches
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="globo" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Interconexión de sucursales por VPN
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="escudo" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Permisos y confidencialidad de los datos
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>

    <x-cta-contacto />

</x-layouts.base>
