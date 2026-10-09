<x-layouts.base :titulo="$servicio['meta_titulo']" :descripcion="$servicio['meta_descripcion']">

    <x-cabecera-pagina
        :titular="$servicio['titular']"
        entradilla="Acceso desde cualquier lugar."
        entradilla2="Nunca ha sido tan fácil centralizar mi empresa."
        :migas="$migas"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-[1fr_20rem]">

            <div class="prosa">
                <h2>Tu servidor en la Nube</h2>

                <p>
                    Con nuestros servidores Cloud tendrá su servidor fuera de su empresa, ubicado en uno
                    de los Data Center más potentes de España.
                </p>

                <p>
                    Hace unos años, plantear a una empresa tener su servidor fuera de sus instalaciones
                    era como decirles que sus datos serían visibles y accesibles por todo el mundo. Hoy
                    en día son ya muchas las empresas que tienen sus servidores principales fuera, «en
                    la nube», pues las ventajas que ofrece el cloud son muchísimas.
                </p>

                <p class="pregunta">¿qué ventajas me ofrece el cloud?</p>
                <p>Son muchas; entre ellas vamos a enumerar algunas:</p>

                <ul class="mt-6 space-y-4">
                    @foreach ([
                        ['icono' => 'servidor', 'titulo' => 'Escalabilidad',
                         'texto' => 'Puedo hacer crecer mi servidor en recursos «RAM, HDD, CPU…» según mis necesidades.'],
                        ['icono' => 'escudo', 'titulo' => 'Seguridad',
                         'texto' => 'Todos nuestros servidores están ubicados en uno de los Data Center más potentes de España.'],
                        ['icono' => 'copia', 'titulo' => 'Poca inversión',
                         'texto' => 'El pago se realiza mensualmente: sólo pago por la máquina contratada.'],
                        ['icono' => 'globo', 'titulo' => 'Ancho de banda altísimo',
                         'texto' => 'Uno de los principales inconvenientes de los servidores es el ancho de banda de '
                                  . 'nuestras ADSL, sobre todo la velocidad de subida, siendo las más comunes de 765 kb, '
                                  . '1 MB o 2 MB. El Data Center nos ofrece anchos de banda de subida de 100 MB a 300 MB, '
                                  . 'por lo tanto la conexión simultánea a nuestro servidor será rapidísima.'],
                        ['icono' => 'llave', 'titulo' => 'Ahorro',
                         'texto' => '¡Sí! Ahorro. Nuestro servidor ya no está en la empresa, por lo tanto tendremos un '
                                  . 'ahorro de luz —«400 W a 800 W de gasto» × 365 días al año— y además no debemos '
                                  . 'contratar anchos de banda de subida extra con la compañía de telefonía.'],
                    ] as $ventaja)
                        <li class="rounded-tarjeta border border-linea bg-tarjeta p-5">
                            <x-icono :nombre="$ventaja['icono']" class="h-5 w-5 text-azafran"/>
                            <h3 class="mt-2 font-display font-semibold text-tinta">{{ $ventaja['titulo'] }}</h3>
                            <p class="mt-1 text-sm leading-relaxed text-tenue">{{ $ventaja['texto'] }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>

            <aside class="space-y-4 lg:pt-2">
                <figure class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta">
                    <img src="{{ asset('images/servicios/cloud.jpg') }}"
                         alt="Servidor cloud en Data Center de VS Informática"
                         width="244" height="241" loading="lazy"
                         class="w-full object-cover">
                </figure>

                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                    <p class="etiqueta text-[11px] text-tenue">Lo que incluye</p>
                    <ul class="mt-4 space-y-3 text-sm text-tinta">
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="servidor" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Escalabilidad RAM, CPU, disco bajo demanda
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="escudo" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Data Center Tier III en España
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="globo" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Ancho de banda 100-300 MB simétrico
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="copia" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Pago mensual sin inversión inicial
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>

    <x-cta-contacto />

</x-layouts.base>
