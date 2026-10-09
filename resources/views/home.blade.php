@php
    /*
     | Las cuatro tarjetas de la home del sitio original, con sus textos
     | literales y sus destinos originales. Ojo: NO son las cuatro secciones
     | del menú — "Infraestructura de red" y "Reparación hardware" son páginas
     | hijas de Hardware. Se respeta a dónde apuntaban.
     */
    $tarjetas = [
        [
            'titulo' => 'A3Erp Software Empresarial',
            'texto'  => 'La solución de gestión que optimiza todas las áreas de su empresa. '
                      . 'a3ERP se adapta al 100% a las necesidades de la empresa, sea cual sea '
                      . 'su estructura y actividad.',
            'ruta'   => 'software-gestion-a3erp',
            'imagen' => 'images/home/a3erp.jpg',
            'alt'    => 'a3ERP, el software de gestión empresarial que implanta VS Informática',
            'icono'  => 'software',
        ],
        [
            'titulo' => 'Infraestructura de red',
            'texto'  => 'No deje la seguridad e infraestructura de su empresa a cualquiera. '
                      . 'Somos expertos en servidores, redes y seguridad.',
            'ruta'   => 'redes-y-servidores',
            'imagen' => 'images/home/infraestructura-red.jpg',
            'alt'    => 'Estructuración de red empresarial montada por VS Informática',
            'icono'  => 'red',
        ],
        [
            'titulo' => 'Cloud - Servicios en la nube',
            'texto'  => 'Copias de Seguridad fuera de su empresa, Servidor Cloud, Correo '
                      . 'electrónico empresarial y Hospedaje profesional...',
            'ruta'   => 'cloud',
            'imagen' => 'images/home/cloud.png',
            'alt'    => 'Servicios en la nube para empresas: servidor, copias, correo y alojamiento',
            'icono'  => 'nube',
        ],
        [
            'titulo' => 'Reparación hardware',
            'texto'  => 'Contamos con taller propio, reparamos sus puestos informáticos en un '
                      . 'tiempo record y con la máxima calidad.',
            'ruta'   => 'reparacion',
            'imagen' => 'images/home/reparacion.png',
            'alt'    => 'Taller propio de reparación de equipos informáticos en La Roda',
            'icono'  => 'llave',
        ],
    ];
@endphp

<x-layouts.base
    descripcion="Informática para empresas en La Roda y Albacete desde 1997. Distribuidores de a3ERP,
                 servidores, redes, seguridad, copias de seguridad y reparación con taller propio.">

    {{-- ================= HERO =================
         Sin carrusel: los tres mensajes que rotaban en el slider del sitio
         antiguo están todos en la página, sin que nadie tenga que esperar a
         que pasen. El titular es el del segundo pase, que era el que hablaba
         del cliente y no del producto. --}}
    <section class="border-b border-linea">
        <div class="contenedor py-14 lg:py-20">
            <div class="grid items-center gap-12 lg:grid-cols-[1.15fr_1fr]">

                <div>
                    <h1 class="font-display text-4xl font-semibold leading-[1.08] tracking-tight
                               text-tinta sm:text-5xl lg:text-6xl">
                        Preocúpate sólo de tu negocio
                    </h1>

                    <p class="mt-5 max-w-xl text-lg leading-relaxed text-tenue sm:text-xl">
                        De la tecnología nos ocupamos nosotros.
                    </p>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('contacto') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-boton bg-azafran
                                  px-6 py-3.5 font-medium text-sobre-azafran transition hover:bg-azafran-fuerte">
                            Cuéntanos qué necesitas
                        </a>
                        <a href="tel:{{ config('empresa.telefono.e164') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-boton border
                                  border-linea bg-papel px-6 py-3.5 font-sans font-semibold tabular-nums text-tinta
                                  transition hover:border-linea-fuerte">
                            <x-icono nombre="telefono" class="h-4 w-4"/>
                            {{ config('empresa.telefono.legible') }}
                        </a>
                    </div>

                    <dl class="mt-10 grid max-w-lg grid-cols-3 gap-6 border-t border-linea pt-6">
                        <div>
                            <dt class="etiqueta text-[11px] text-tenue">Contigo desde</dt>
                            <dd class="mt-1 font-display text-2xl font-semibold text-tinta">1997</dd>
                        </div>
                        <div>
                            <dt class="etiqueta text-[11px] text-tenue">Taller propio</dt>
                            <dd class="mt-1 font-display text-2xl font-semibold text-tinta">desde 1998</dd>
                        </div>
                        <div>
                            <dt class="etiqueta text-[11px] text-tenue">Partner Intel</dt>
                            <dd class="mt-1 font-display text-2xl font-semibold text-tinta">desde 2008</dd>
                        </div>
                    </dl>
                </div>

                {{-- La ficha del taller. No es una foto de stock de un data
                     center: es su mostrador, y está a dos calles. --}}
                <div class="lg:justify-self-end">
                    <figure class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta shadow-suave">
                        <img src="{{ asset('images/empresa/taller-mostrador.jpg') }}"
                             alt="Mostrador de la tienda de VS Informática en La Roda, con equipos montados y listos para entregar"
                             width="259" height="194"
                             class="w-full object-cover">

                        <figcaption class="space-y-3 border-t border-linea p-5">
                            <p class="font-display font-semibold text-tinta">Estamos en La Roda</p>

                            <p class="flex items-start gap-2 text-sm text-tenue">
                                <x-icono nombre="mapa" class="mt-0.5 h-4 w-4 shrink-0"/>
                                <span>
                                    {{ config('empresa.direccion.calle') }}<br>
                                    {{ config('empresa.direccion.cp') }} {{ config('empresa.direccion.localidad') }}
                                    ({{ config('empresa.direccion.provincia') }})
                                </span>
                            </p>

                            <p class="flex items-start gap-2 text-sm text-tenue">
                                <x-icono nombre="reloj" class="mt-0.5 h-4 w-4 shrink-0"/>
                                <span>{{ config('empresa.horario.texto') }}</span>
                            </p>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= DESTACADOS =================
         Los otros dos mensajes que rotaban en el carrusel. --}}
    <section class="border-b border-linea bg-niebla">
        <div class="contenedor py-12 lg:py-16">
            <div data-anim="lista" class="grid gap-5 md:grid-cols-2">

                <a href="{{ route('servicios.show', 'software-gestion-a3erp') }}"
                   class="group flex flex-col justify-between gap-6 rounded-tarjeta border border-linea
                          bg-tarjeta p-7 transition hover:border-linea-fuerte hover:shadow-suave">
                    <div>
                        <p class="etiqueta text-[11px] text-azafran-oscuro">
                            Elegido el mejor ERP de 2016
                        </p>
                        <h2 class="mt-3 font-display text-2xl font-semibold text-tinta">
                            a3ERP Partner Associate
                        </h2>
                        <p class="mt-2 text-[15px] text-tenue">
                            Somos distribuidores autorizados y lo adaptamos a lo que hace tu empresa.
                        </p>
                    </div>
                    <img src="{{ asset('images/partners/a3erp.jpg') }}"
                         alt="a3ERP de A3 Software (Wolters Kluwer)"
                         width="465" height="235"
                         loading="lazy"
                         class="h-10 w-auto self-start object-contain dark:brightness-0 dark:invert">
                </a>

                <a href="{{ route('contacto') }}"
                   class="group flex flex-col justify-between gap-6 rounded-tarjeta border border-linea
                          bg-tarjeta p-7 transition hover:border-linea-fuerte hover:shadow-suave">
                    <div>
                        <p class="etiqueta text-[11px] text-azafran-oscuro">
                            Su oficina completa en la nube
                        </p>
                        <h2 class="mt-3 font-display text-2xl font-semibold text-tinta">
                            Office 365 para pymes y centros educativos
                        </h2>
                        <p class="mt-2 text-[15px] text-tenue">
                            Para obtener más información acerca de Office 365 para pymes y centros
                            educativos... consúltenos, ¡se sorprenderá!
                        </p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 font-medium text-sm text-azafran-oscuro">
                        Consúltenos
                        <x-icono nombre="flecha" class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5"/>
                    </span>
                </a>
            </div>
        </div>
    </section>

    {{-- ================= SERVICIOS ================= --}}
    <section class="contenedor py-16 lg:py-20">
        <div class="max-w-2xl">
            <p class="etiqueta text-[11px] text-tenue">Qué hacemos</p>
            <h2 class="mt-3 font-display text-3xl font-semibold tracking-tight text-tinta sm:text-4xl">
                Todo lo que tu empresa necesita, en la misma casa
            </h2>
        </div>

        <ul data-anim="lista" class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($tarjetas as $tarjeta)
                <li class="flex">
                    <a href="{{ route('servicios.show', $tarjeta['ruta']) }}"
                       class="group flex flex-1 flex-col overflow-hidden rounded-tarjeta border
                              border-linea bg-tarjeta transition hover:border-linea-fuerte hover:shadow-suave">
                        <img src="{{ asset($tarjeta['imagen']) }}"
                             alt="{{ $tarjeta['alt'] }}"
                             width="465" height="235"
                             loading="lazy"
                             class="aspect-[465/235] w-full border-b border-linea object-cover">

                        <div class="flex flex-1 flex-col p-6">
                            <x-icono :nombre="$tarjeta['icono']" class="h-7 w-7 text-azafran"/>
                            <h3 class="mt-4 font-display text-lg font-semibold leading-snug text-tinta">
                                {{ $tarjeta['titulo'] }}
                            </h3>
                            <p class="mt-2 flex-1 text-[15px] leading-relaxed text-tenue">
                                {{ $tarjeta['texto'] }}
                            </p>
                            <span class="mt-5 inline-flex items-center gap-1.5 font-medium text-sm text-azafran-oscuro">
                                Ver más
                                <x-icono nombre="flecha" class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5"/>
                            </span>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </section>

    {{-- ================= EL RACK =================
         Va justo después de las tarjetas de servicio porque hace de puente:
         las tarjetas dicen QUÉ hacemos y el rack enseña CÓMO se ve montado. --}}
    <x-rack-3d />

    {{-- ================= POR QUÉ NOSOTROS ================= --}}
    <section class="border-t border-linea bg-niebla">
        <div class="contenedor py-16 lg:py-20">
            <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                <div>
                    <p class="etiqueta text-[11px] text-tenue">Quiénes somos</p>
                    <h2 class="mt-3 font-display text-3xl font-semibold tracking-tight text-tinta sm:text-4xl">
                        Somos ingenieros informáticos, y estamos aquí al lado
                    </h2>
                    <div class="prosa mt-6">
                        <p>
                            Empresa fundada en el año 1997 en la localidad de La Roda, provincia de
                            Albacete. Con ilusión y mucho trabajo nos hemos consolidado como una
                            empresa fiable, responsable y de calidad.
                        </p>
                        <p>
                            Somos expertos en infraestructura de red, reparamos a nivel de hardware
                            con taller propio y somos partner de marcas como HP, Western Digital,
                            Intel y de uno de los mejores ERP del mercado, a3ERP.
                        </p>
                    </div>

                    <a href="{{ route('empresa') }}"
                       class="mt-7 inline-flex items-center gap-1.5 font-medium text-sm text-azafran-oscuro
                              underline-offset-4 hover:underline">
                        Conócenos
                        <x-icono nombre="flecha" class="h-3.5 w-3.5"/>
                    </a>
                </div>

                <div data-anim="lista" class="grid grid-cols-2 gap-4">
                    <figure class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta">
                        <img src="{{ asset('images/empresa/taller-nas.jpg') }}"
                             alt="Servidor NAS en rack preparado por VS Informática, con sus bahías de disco"
                             width="297" height="170" loading="lazy"
                             class="aspect-[297/170] w-full object-cover">
                    </figure>
                    <figure class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta">
                        <img src="{{ asset('images/empresa/taller-bahias.jpg') }}"
                             alt="Bahías de disco duro extraíbles de los servidores que monta VS Informática"
                             width="331" height="152" loading="lazy"
                             class="aspect-[297/170] w-full object-cover">
                    </figure>
                    <figure class="col-span-2 overflow-hidden rounded-tarjeta border border-linea bg-tarjeta">
                        <img src="{{ asset('images/empresa/taller-mostrador.jpg') }}"
                             alt="Interior de la tienda de VS Informática en La Roda"
                             width="259" height="194" loading="lazy"
                             class="aspect-[16/7] w-full object-cover">
                    </figure>
                </div>
            </div>
        </div>
    </section>

    <x-cta-contacto
        texto="¿Hablamos? Cuéntanos qué necesita tu empresa y te decimos por dónde empezar."
        boton="Escríbenos"/>

</x-layouts.base>
