<x-layouts.base :titulo="$servicio['meta_titulo']" :descripcion="$servicio['meta_descripcion']">

    <x-cabecera-pagina
        :titular="$servicio['titular']"
        :entradilla="$servicio['entradilla']"
        :entradilla2="$servicio['entradilla_2']"
        :migas="$migas"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-[1fr_20rem]">

            <div class="prosa">
                <h2>Equipos, consumibles y más</h2>

                <p>
                    Queremos lo mejor para ti y sabemos todas tus necesidades. Además de nuestros
                    servicios principales, en nuestra tienda de La Roda encontrarás equipos de
                    escritorio y portátiles a medida, y consumibles para tu impresora.
                </p>

                <p>
                    Montamos equipos con componentes de primeras marcas, Partner de Intel desde 2008.
                    Bajo nivel sonoro, disipadores pasivos y servicio postventa en el propio taller.
                </p>

                <p>
                    ¿No encuentras tu referencia de tóner o cartucho? Pásate por la tienda con el
                    cartucho vacío: se la identificamos nosotros y te la traemos en tiempo récord.
                </p>
            </div>

            <aside class="space-y-4 lg:pt-2">
                <figure class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta">
                    <img src="{{ asset('images/servicios/equipos.jpg') }}"
                         alt="Equipos de escritorio montados a medida por VS Informática"
                         width="244" height="241" loading="lazy"
                         class="w-full object-cover">
                </figure>

                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                    <p class="etiqueta text-[11px] text-tenue">Lo que tenemos</p>
                    <ul class="mt-4 space-y-3 text-sm text-tinta">
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="portatil" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Equipos de escritorio y portátiles a medida
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="impresora" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Consumibles láser y tinta en tienda
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="llave" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Servicio postventa en taller propio
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="caja" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Componentes de primeras marcas (Intel Partner)
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>

    <x-cta-contacto />

</x-layouts.base>
