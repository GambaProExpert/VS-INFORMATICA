<x-layouts.base :titulo="$servicio['meta_titulo']" :descripcion="$servicio['meta_descripcion']">

    <x-cabecera-pagina
        :titular="$servicio['titular']"
        :entradilla="$servicio['entradilla']"
        :entradilla2="$servicio['entradilla_2']"
        :migas="$migas"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-[1fr_20rem]">

            <div class="prosa">
                <p>
                    Somos una empresa en crecimiento que se centra en las tecnologías cloud más modernas.
                    Ofrecemos servicios en la nube para que su empresa crezca sin límites de infraestructura.
                </p>

                <p>
                    Desde servidores virtuales hasta copias de seguridad remotas, pasando por correo
                    empresarial y alojamiento web. Todo gestionado desde nuestros Data Centers en España,
                    con la seguridad y el ancho de banda que su negocio necesita.
                </p>

                <p>
                    El cloud no es solo «alquilar un servidor», es disponibilidad, escalabilidad y
                    tranquilidad. Nosotros nos ocupamos de la tecnología; usted, de su negocio.
                </p>
            </div>

            <aside class="space-y-4 lg:pt-2">
                <figure class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta">
                    <img src="{{ asset('images/servicios/cloud.jpg') }}"
                         alt="Servicios cloud de VS Informática"
                         width="244" height="241" loading="lazy"
                         class="w-full object-cover">
                </figure>

                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                    <p class="etiqueta text-[11px] text-tenue">Lo que ofrecemos</p>
                    <ul class="mt-4 space-y-3 text-sm text-tinta">
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="nube-servidor" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Servidor Cloud en Data Center español
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="copia" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Copias de seguridad remotas automáticas
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="sobre" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Correo empresarial con su dominio
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="globo" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Alojamiento web y registro de dominios
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>

    <x-cta-contacto />

</x-layouts.base>
