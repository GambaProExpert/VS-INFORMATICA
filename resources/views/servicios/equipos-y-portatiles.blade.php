<x-layouts.base :titulo="$servicio['meta_titulo']" :descripcion="$servicio['meta_descripcion']">

    <x-cabecera-pagina
        :titular="$servicio['titular']"
        entradilla="Atención personalizada."
        entradilla2="Servicio postventa."
        :migas="$migas"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-[1fr_20rem]">

            <div class="prosa">
                <p>
                    Nuestro principal objetivo desde el año 1998 es <strong>la calidad</strong>. Por
                    ello realizamos montajes de equipos informáticos personalizados con componentes
                    de primeras marcas, dando como resultado equipos de altas prestaciones. Nuestros
                    equipos salen de fábrica con un nivel sonoro muy bajo, dedicando para ello tiempo
                    e innovación a la búsqueda de disipadores pasivos y ventiladores de alta calidad
                    y nivel sonoro bajo.
                </p>

                <p>
                    Solucionamos cualquier tipo de problema hardware y software <strong>en nuestro
                    taller</strong>, orientando y asesorando a nuestros clientes, todo ello con un
                    trato totalmente personalizado.
                </p>

                <p>
                    Trabajamos con los mejores fabricantes de componentes del mercado, ensamblando
                    equipos de alta calidad y fiabilidad. Una muestra de ello es que somos
                    <strong>Partner de Intel desde el año 2008</strong>.
                </p>
            </div>

            <aside class="space-y-4 lg:pt-2">
                <figure class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta">
                    <img src="{{ asset('images/servicios/equipos.jpg') }}"
                         alt="Equipo de escritorio montado a medida por VS Informática"
                         width="244" height="241" loading="lazy"
                         class="w-full object-cover">
                </figure>

                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                    <p class="etiqueta text-[11px] text-tenue">Lo que cuidamos</p>
                    <ul class="mt-4 space-y-3 text-sm text-tinta">
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="caja" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Componentes de primeras marcas
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="llave" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Disipadores pasivos y bajo nivel sonoro
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="portatil" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Servicio postventa en el propio taller
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>

    <x-cta-contacto />

</x-layouts.base>
