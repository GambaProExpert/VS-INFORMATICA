<x-layouts.base :titulo="$servicio['meta_titulo']" :descripcion="$servicio['meta_descripcion']">

    <x-cabecera-pagina
        :titular="$servicio['titular']"
        entradilla="Reparación de sus puestos informáticos."
        entradilla2="Servidor, PC, portátiles, impresoras..."
        :migas="$migas"/>

    <div class="contenedor py-14 lg:py-20">

        <p class="font-display text-2xl font-semibold text-tinta sm:text-3xl">
            Taller propio, con material en stock.
        </p>

        <div class="mt-12 grid gap-12 lg:grid-cols-[1fr_20rem]">

            <div class="prosa">
                <h2>Servicio Integral</h2>

                <p>
                    Las averías tanto a nivel de «hardware» como de «software» en equipos de
                    escritorio, ordenadores portátiles, servidores y redes de comunicación son muy
                    comunes, causando importantes pérdidas en la actividad diaria de una empresa.
                </p>

                <p>
                    La inmensa mayoría de las PYMES no se pueden permitir tener un Departamento
                    Técnico, por ello ofrecemos a la PYME disponer de un Departamento Técnico
                    Especializado con instalaciones propias, material y técnicos altamente
                    cualificados, proporcionando una asistencia técnica integral, personalizada y
                    económica. Los tipos de asistencia que ofrecemos son:
                </p>

                <ul>
                    <li>Mantenimiento semestral o anual de sus equipos informáticos, redes, seguridad, etc.</li>
                    <li>Asistencia «on-site» a domicilio.</li>
                    <li>Asistencia «on-line» o remota.</li>
                </ul>

                <p>
                    Nuestro objetivo es que la PYME no se preocupe de los temas informáticos:
                    ofrecemos mantenimientos personalizados y adaptados a las necesidades de cada
                    empresa. Somos especialistas en redes locales, interconexión de sedes mediante
                    VPN, seguridad, reparación de componentes hardware, etc.
                </p>
            </div>

            <aside class="space-y-4 lg:pt-2">
                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                    <p class="etiqueta text-[11px] text-tenue">
                        ¿Necesita ayuda ahora?
                    </p>
                    <p class="mt-3 text-sm text-tenue">
                        Si la avería se puede ver en remoto, descargue nuestro cliente de soporte y
                        llámenos: normalmente se resuelve en la misma llamada.
                    </p>
                    <a href="{{ route('soporte') }}"
                       class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-boton
                              border border-linea px-4 py-2.5 text-sm font-medium text-tinta
                              transition hover:border-linea-fuerte">
                        <x-icono nombre="descarga" class="h-4 w-4"/>
                        Soporte remoto
                    </a>
                </div>

                <figure class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta">
                    <img src="{{ asset('images/empresa/taller-mostrador.jpg') }}"
                         alt="Equipos reparados y listos para entregar en el taller de VS Informática"
                         width="259" height="194" loading="lazy"
                         class="w-full object-cover">
                    <figcaption class="border-t border-linea p-4 text-xs text-tenue">
                        Nuestro taller en {{ config('empresa.direccion.calle') }},
                        {{ config('empresa.direccion.localidad') }}.
                    </figcaption>
                </figure>
            </aside>
        </div>
    </div>

    <x-cta-contacto />

</x-layouts.base>
