<x-layouts.base :titulo="$servicio['meta_titulo']" :descripcion="$servicio['meta_descripcion']">

    <x-cabecera-pagina
        :titular="$servicio['titular']"
        entradilla="¿Dónde almaceno mi página web"
        entradilla2="y mis correos electrónicos?"
        :migas="$migas"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-[1fr_20rem]">

            <div class="prosa">
                <h2>Hosting y dominios para su empresa</h2>

                <p>
                    ¿Dónde almaceno mi página web y mis correos electrónicos?
                    Tenemos varios planes de alojamiento (Mínimo, Medio, Profesional, Plus, etc.).
                    Asesoramos a nuestros clientes sobre el plan que mejor se adapte a sus necesidades.
                </p>

                {{-- Los tres bloques que encabezaban esta página en el sitio original --}}
                <ul data-anim="lista" class="mt-8 grid gap-5 sm:grid-cols-3">
                    <li class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                        <x-icono nombre="servidor" class="h-7 w-7 text-azafran"/>
                        <h2 class="mt-4 font-display text-lg font-semibold text-tinta">Alojamiento Web (hosting)</h2>
                        <p class="mt-2 text-[15px] text-tenue">
                            Planes Mínimo, Medio, Profesional y Plus. Le asesoramos sobre cuál encaja con lo
                            que necesita.
                        </p>
                    </li>
                    <li class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                        <x-icono nombre="globo" class="h-7 w-7 text-azafran"/>
                        <h2 class="mt-4 font-display text-lg font-semibold text-tinta">Registro de Dominio</h2>
                        <p class="mt-2 text-[15px] text-tenue">
                            Su nombre en Internet, reservado a su nombre. Por menos de 20 € al año.
                        </p>
                    </li>
                    <li class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                        <x-icono nombre="sobre" class="h-7 w-7 text-azafran"/>
                        <h2 class="mt-4 font-display text-lg font-semibold text-tinta">Solicita Información</h2>
                        <p class="mt-2 text-[15px] text-tenue">
                            Cuéntenos qué tiene y qué necesita, y le decimos qué plan le conviene.
                        </p>
                        <a href="{{ route('contacto') }}"
                           class="mt-4 inline-flex items-center gap-1.5 font-medium text-sm text-azafran-oscuro
                                  underline-offset-4 hover:underline">
                            Solicitud de información
                            <x-icono nombre="flecha" class="h-3.5 w-3.5"/>
                        </a>
                    </li>
                </ul>

                <x-faq class="mt-10" :preguntas="[
                    [
                        'pregunta' => '¿nuestros alojamientos o hosting?',
                        'respuesta' => 'Tenemos varios planes de alojamiento (Mínimo, Medio, Profesional, Plus, etc.). '
                                     . 'Asesoramos a nuestros clientes sobre el plan que mejor se adapte a sus necesidades.',
                    ],
                    [
                        'pregunta' => '¿qué diferencia hay entre dominio y alojamiento (hosting)?',
                        'respuesta' => 'No basta con registrar un nombre de dominio para poder tener nuestra web: '
                                     . 'necesitamos también un hosting o alojamiento. El hosting o alojamiento web es '
                                     . 'un espacio en el disco duro de un servidor que tiene conexión permanente a '
                                     . 'Internet y que es alquilado generalmente por un usuario (persona u organización) '
                                     . 'para publicar información en Internet, generalmente en forma de sitio web.',
                    ],
                    [
                        'pregunta' => '¿por qué me interesa registrar un dominio?',
                        'respuesta' => 'El coste anual de un dominio suele ser inferior a los 20,00 €, además de la '
                                     . 'importancia que tiene para mi empresa reservar un nombre «que será único», '
                                     . 'permitiendo que cualquier usuario de la red localice nuestra página web o nos '
                                     . 'escriba un correo electrónico.',
                    ],
                    [
                        'pregunta' => '¿qué nombre escojo?',
                        'respuesta' => 'En principio, una empresa estará interesada en utilizar un nombre de dominio '
                                     . 'que coincida con su nombre comercial o marca, siempre y cuando el nombre se '
                                     . 'encuentre disponible.',
                    ],
                    [
                        'pregunta' => '¿puedo reservar mi dominio sin tener página web?',
                        'respuesta' => 'Sí. De hecho, muchos particulares, autónomos y empresas reservan un nombre de '
                                     . 'dominio pensando en realizar una página web en un futuro próximo o lejano.',
                    ],
                ]"/>
            </div>

            <aside class="space-y-4 lg:pt-2">
                <figure class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta">
                    <img src="{{ asset('images/servicios/cloud-plataforma.jpg') }}"
                         alt="Alojamiento web y dominios en la nube de VS Informática"
                         width="244" height="241" loading="lazy"
                         class="w-full object-cover">
                </figure>

                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                    <p class="etiqueta text-[11px] text-tenue">Lo que ofrecemos</p>
                    <ul class="mt-4 space-y-3 text-sm text-tinta">
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="servidor" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Hosting Mínimo, Medio, Profesional, Plus
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="globo" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Registro de dominios .es, .com, .eu...
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="escudo" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            SSL gratis, backups diarios, PHP 8.x
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="sobre" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Cuentas de correo incluidas
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>

    <x-cta-contacto
        texto="No lo dude, contacte con nosotros, estaremos encantados de hablar con usted."
        boton="Solicitud de información"/>

</x-layouts.base>
