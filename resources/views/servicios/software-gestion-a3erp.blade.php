@php
    /*
     | La galería se lee del disco en vez de listarse a mano: añadir una
     | captura nueva es dejarla en public/images/a3erp/galeria y volver a
     | lanzar scripts/optimizar-imagenes.mjs.
     */
    $galeria = collect(glob(public_path('images/a3erp/galeria/mini/*.webp')))
        ->map(function (string $ruta) {
            $nombre = pathinfo($ruta, PATHINFO_FILENAME);

            return [
                'mini'   => asset("images/a3erp/galeria/mini/{$nombre}.webp"),
                'grande' => asset("images/a3erp/galeria/{$nombre}.webp"),
                'alt'    => "Pantalla {$nombre} de a3ERP",
            ];
        })
        ->values()
        ->all();

    $lineas = [
        [
            'nombre' => 'a3ERP one',
            'imagen' => 'images/a3erp/one.jpg',
            'titular' => 'La solución integral de gestión para profesionales independientes',
            'lema' => 'Te ofrece una visión 360º para una gestión óptima de tu empresa.',
            'texto' => 'Es la solución pensada para cubrir y adaptarse a las necesidades de micropymes, '
                     . 'autónomos y profesionales independientes. Con a3ERP|one tendrás una visión completa '
                     . 'de todas las áreas que forman parte de tu negocio, funcionando de forma integrada y '
                     . 'dándote un control absoluto de tu empresa. Con una interfaz muy intuitiva y fácil de '
                     . 'usar, dispondrás de toda la información en tiempo real, facilitándote la toma de '
                     . 'decisiones en todo momento. Y cuentas con las mayores funcionalidades para que '
                     . 'automatices tareas, optimices tus recursos e incrementes la productividad y eficiencia '
                     . 'en la gestión contable, de almacén y facturación.',
        ],
        [
            'nombre' => 'a3ERP base',
            'imagen' => 'images/a3erp/base.png',
            'titular' => 'Una gran gestión para autónomos y microempresas',
            'lema' => 'Integral (Contabilidad + Facturación).',
            'texto' => 'Una completa solución de facturación, contabilidad y gestión de almacén pensada para '
                     . 'las necesidades de autónomos y microempresas que únicamente precisan de un puesto de '
                     . 'trabajo.',
        ],
        [
            'nombre' => 'a3ERP profesional',
            'imagen' => 'images/a3erp/profesional.png',
            'titular' => 'Un ERP fácil de implantar para pequeñas empresas',
            'lema' => 'Hasta cuatro puestos de trabajo.',
            'texto' => 'Controla y analiza de forma total y efectiva todos los procesos administrativos y de '
                     . 'negocio de la empresa, integrados en una única solución y con gran capacidad de '
                     . 'adaptación a las pequeñas empresas que requieren de un ERP con hasta cuatro puestos '
                     . 'de trabajo.',
        ],
        [
            'nombre' => 'a3ERP plus',
            'imagen' => 'images/a3erp/plus.png',
            'titular' => 'Un ERP 100% diseñado para adaptarse a la PYME',
            'lema' => 'Sin límite de usuarios, con Inteligencia de Negocio.',
            'texto' => 'La solución ideal para pymes que precisan de un completo ERP para controlar todas las '
                     . 'áreas de la empresa, sin límite de usuarios, potente, rápido de implantar, con amplias '
                     . 'funcionalidades y preparado para adaptarse completamente a las necesidades de la pyme, '
                     . 'sea cual sea su actividad y tamaño. Incorpora un potente módulo de Inteligencia de '
                     . 'Negocio (BI o Business Intelligence) para una mejor toma de decisiones en base a la '
                     . 'información en tiempo real de todos los departamentos de la empresa, optimizando la '
                     . 'gestión integral.',
        ],
        [
            'nombre' => 'a3ERP premium',
            'imagen' => 'images/a3erp/premium.png',
            'titular' => 'Un ERP para empresas que van más allá',
            'lema' => 'Para medianas y grandes empresas con necesidades complejas.',
            'texto' => 'Gestión integrada para medianas y grandes empresas con necesidades complejas, '
                     . 'incorporando herramientas de programación y parametrización para asegurar sus propias '
                     . 'adaptaciones y controlar el sistema de gestión desde el back office. Su misión es '
                     . 'optimizar todos los circuitos de la empresa, adaptándose a la complejidad de sus '
                     . 'procesos, y obtener el máximo rendimiento y eficacia en la gestión global de la compañía.',
        ],
    ];
@endphp

<x-layouts.base :titulo="$servicio['meta_titulo']" :descripcion="$servicio['meta_descripcion']">

    <x-cabecera-pagina
        :titular="$servicio['titular']"
        entradilla="Solución integral de gestión para PYMES."
        entradilla2="Más y mayor eficiencia, más facilidad."
        :migas="$migas"/>

    <div class="contenedor py-14 lg:py-20">

        <div class="grid gap-10 lg:grid-cols-[1fr_16rem] lg:items-start">
            <div class="prosa">
                <p>
                    Somos <strong>Distribuidores Autorizados «Partner Associate»</strong> de a3ERP,
                    una de las herramientas de software de gestión empresarial más avanzadas del
                    mercado. Adaptamos a3ERP a las necesidades específicas de cada cliente.
                </p>

                <p>
                    a3ERP te ofrece una visión de 360º de tu empresa, gestionando todas sus áreas
                    —Laboral, Comercial, Compras, Logística, Producción y Financiera— para optimizar
                    recursos, simplificar procesos y ayudarte en la toma de decisiones para una
                    gestión eficiente.
                </p>

                <p>
                    a3ERP es la solución de gestión empresarial que integra todas las áreas de la
                    pyme de una forma ágil y sencilla, contribuyendo a aumentar tu productividad y
                    competitividad, y a facilitar la toma de decisiones para una gestión global y
                    eficiente de tu empresa.
                </p>

                <p>
                    a3ERP se adapta al 100% a las necesidades de la empresa, sea cual sea su
                    estructura y actividad, aportando las máximas prestaciones de análisis y control
                    en un entorno de trabajo único, y asegurando en todo momento su constante
                    evolución a los cambios normativos y tecnológicos.
                </p>
            </div>

            <aside class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                <img src="{{ asset('images/partners/a3erp.jpg') }}"
                     alt="a3ERP, de A3 Software (Wolters Kluwer)"
                     width="465" height="235"
                     class="h-11 w-auto object-contain dark:brightness-0 dark:invert">
                <p class="mt-4 etiqueta text-[11px] text-tenue">
                    Elegido el mejor ERP de 2016
                </p>
                <p class="mt-3 text-sm text-tenue">
                    Somos Partner Associate: no solo lo vendemos, lo implantamos, lo adaptamos y lo
                    mantenemos nosotros desde La Roda.
                </p>
                <a href="{{ route('contacto') }}"
                   class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-boton
                          bg-azafran px-4 py-2.5 text-sm font-medium text-sobre-azafran transition
                          hover:bg-azafran-fuerte">
                    Pedir una demostración
                </a>
            </aside>
        </div>

        {{-- ========== LÍNEAS DE PRODUCTO ========== --}}
        <section class="mt-16 lg:mt-20">
            <h2 class="font-display text-2xl font-semibold tracking-tight text-tinta sm:text-3xl">
                Líneas de producto
            </h2>
            <p class="mt-2 max-w-2xl text-tenue">
                De autónomo a empresa mediana: cinco versiones para que no pagues por lo que no vas a usar.
            </p>

            <ul data-anim="lista" class="mt-8 space-y-4">
                @foreach ($lineas as $linea)
                    <li class="rounded-tarjeta border border-linea bg-tarjeta p-6 lg:p-7">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-start">
                            <img src="{{ asset($linea['imagen']) }}"
                                 alt="Logotipo de {{ $linea['nombre'] }}"
                                 width="105" height="105" loading="lazy"
                                 class="h-16 w-16 shrink-0 rounded-boton object-contain">

                            <div class="medida">
                                <h3 class="font-display text-xl font-semibold text-tinta">
                                    {{ $linea['nombre'] }}
                                </h3>
                                <p class="mt-1 font-medium text-tinta">{{ $linea['titular'] }}</p>
                                <p class="mt-1 font-medium text-sm text-azafran-oscuro">{{ $linea['lema'] }}</p>
                                <p class="mt-3 leading-relaxed text-tenue">{{ $linea['texto'] }}</p>

                                <a href="{{ route('contacto') }}"
                                   class="mt-4 inline-flex items-center gap-1.5 font-medium text-sm
                                          text-azafran-oscuro underline-offset-4 hover:underline">
                                    Más información
                                    <x-icono nombre="flecha" class="h-3.5 w-3.5"/>
                                </a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>

        {{-- ========== GALERÍA ========== --}}
        @if (! empty($galeria))
            <section class="mt-16 lg:mt-20">
                <h2 class="font-display text-2xl font-semibold tracking-tight text-tinta sm:text-3xl">
                    Así se ve a3ERP
                </h2>
                <p class="mt-2 max-w-2xl text-tenue">
                    {{ count($galeria) }} pantallas reales del programa. Pulsa en cualquiera para verla a tamaño completo.
                </p>

                <x-galeria class="mt-8" :imagenes="$galeria" titulo="Pantallas de a3ERP"/>
            </section>
        @endif
    </div>

    <x-cta-contacto />

</x-layouts.base>
