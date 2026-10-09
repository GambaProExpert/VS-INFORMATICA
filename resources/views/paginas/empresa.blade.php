<x-layouts.base
    titulo="Quiénes somos"
    descripcion="VS Informática La Roda, fundada en 1997. Ingenieros informáticos con taller propio,
                 partner de HP, Intel, Western Digital y a3ERP.">

    <x-cabecera-pagina
        titular="Empresa"
        entradilla="Contigo desde 1997."
        entradilla2="En La Roda, con nombre, apellidos y taller propio."
        :migas="[
            ['titulo' => 'Inicio', 'url' => route('home')],
            ['titulo' => 'Empresa', 'url' => null],
        ]"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-[1fr_20rem] lg:gap-16">

            <div class="prosa">
                <p>
                    Empresa fundada en el año 1997 en la localidad de La Roda, provincia de Albacete.
                    Con ilusión y mucho trabajo nos hemos consolidado como una empresa fiable,
                    responsable y de calidad.
                </p>

                <p>
                    Nuestro lema siempre ha sido dar un servicio de calidad, y para conseguir este
                    objetivo nos hemos especializado en varios aspectos dentro del amplio mundo de la
                    informática, como en la reparación a nivel de hardware de equipos informáticos
                    con taller propio. Somos partner de marcas tan importantes como HP, Western
                    Digital y de uno de los mejores ERP del mercado, a3ERP.
                </p>

                <p>
                    Somos expertos en infraestructura de red y en el diseño y desarrollo web.
                </p>

                <p>
                    Somos ingenieros informáticos, y los años de experiencia y formación han hecho
                    que podamos distribuir primeras marcas. Además somos partner oficiales de marcas
                    como HP, Intel, a3ERP, Avast, Zyxel y Western Digital, entre otras.
                </p>

                <p>
                    Le damos las gracias por leer nuestra breve y apasionante historia.
                </p>
            </div>

            <aside class="space-y-4">
                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                    <p class="etiqueta text-[11px] text-tenue">En cifras</p>
                    <dl class="mt-4 space-y-4">
                        <div>
                            <dt class="text-sm text-tenue">Fundada en</dt>
                            <dd class="font-display text-2xl font-semibold text-tinta">1997</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-tenue">Taller propio desde</dt>
                            <dd class="font-display text-2xl font-semibold text-tinta">1998</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-tenue">Partner de Intel desde</dt>
                            <dd class="font-display text-2xl font-semibold text-tinta">2008</dd>
                        </div>
                    </dl>
                </div>

                <figure class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta">
                    <img src="{{ asset('images/empresa/quienes-somos.png') }}"
                         alt="Distintivos de partner de VS Informática: HP Partner, a3ERP Distribuidor Oficial,
                              Intel Channel Partner, Authorized Reseller, Avast y Western Digital"
                         width="273" height="185" loading="lazy"
                         class="w-full object-contain">
                </figure>
            </aside>
        </div>

        {{-- El taller, con fotos suyas de verdad --}}
        <section class="mt-16 lg:mt-20">
            <h2 class="font-display text-2xl font-semibold tracking-tight text-tinta sm:text-3xl">
                Nuestro taller
            </h2>
            <p class="mt-2 max-w-2xl text-tenue">
                No subcontratamos la reparación: se hace aquí, en {{ config('empresa.direccion.calle') }}.
            </p>

            <ul data-anim="lista" class="mt-8 grid gap-5 sm:grid-cols-3">
                @foreach ([
                    ['img' => 'taller-mostrador.jpg', 'w' => 259, 'h' => 194,
                     'alt' => 'Mostrador de la tienda de VS Informática, con equipos montados listos para entregar',
                     'pie' => 'La tienda, en La Roda.'],
                    ['img' => 'taller-nas.jpg', 'w' => 297, 'h' => 170,
                     'alt' => 'Servidor NAS en rack con el logotipo de VS Informática y sus bahías de disco',
                     'pie' => 'Servidores que montamos y mantenemos nosotros.'],
                    ['img' => 'taller-bahias.jpg', 'w' => 331, 'h' => 152,
                     'alt' => 'Bahías de disco duro extraíbles de los servidores de VS Informática',
                     'pie' => 'Discos en caliente, para que nadie se quede parado.'],
                ] as $foto)
                    <li>
                        <figure class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta">
                            <img src="{{ asset('images/empresa/' . $foto['img']) }}"
                                 alt="{{ $foto['alt'] }}"
                                 width="{{ $foto['w'] }}" height="{{ $foto['h'] }}" loading="lazy"
                                 class="aspect-[4/3] w-full object-cover">
                            <figcaption class="border-t border-linea p-4 text-sm text-tenue">
                                {{ $foto['pie'] }}
                            </figcaption>
                        </figure>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>

    <x-cta-contacto
        texto="¿Quiere conocernos? Estamos en La Roda y se nos puede venir a ver."
        boton="Escríbenos"/>

</x-layouts.base>
