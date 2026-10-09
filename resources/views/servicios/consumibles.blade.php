<x-layouts.base :titulo="$servicio['meta_titulo']" :descripcion="$servicio['meta_descripcion']">

    <x-cabecera-pagina
        :titular="$servicio['titular']"
        entradilla="Para su impresora láser,"
        entradilla2="para su impresora de tinta: tenemos cualquier referencia."
        :migas="$migas"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-[1fr_20rem]">

            <div class="prosa">
                <p>
                    Disponemos de las referencias más importantes y demandadas de consumibles en
                    nuestro local. Y si no lo tenemos, no se preocupe: nosotros se lo localizamos y
                    se lo traemos en un tiempo récord.
                </p>

                <p>
                    Somos expertos en consumibles desde el año 1998.
                </p>
            </div>

            <aside class="lg:pt-2">
                <figure class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta">
                    <img src="{{ asset('images/servicios/consumibles.jpg') }}"
                         alt="Cartuchos de tinta y tóner disponibles en la tienda de VS Informática"
                         width="205" height="147" loading="lazy"
                         class="w-full object-cover">
                    <figcaption class="border-t border-linea p-4 text-xs text-tenue">
                        Pásese por la tienda con la referencia o con el cartucho vacío: se la
                        identificamos nosotros.
                    </figcaption>
                </figure>
            </aside>
        </div>
    </div>

    <x-cta-contacto />

</x-layouts.base>
