<x-layouts.base :titulo="$servicio['meta_titulo']" :descripcion="$servicio['meta_descripcion']">

    <x-cabecera-pagina
        :titular="$servicio['titular']"
        entradilla="¿Cree que su empresa está segura?"
        entradilla2="¿Están seguros sus datos?"
        :migas="$migas"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-[1fr_20rem]">

            <div class="prosa">
                {{-- La auditoría gratuita era la oferta principal de esta página en el
                     sitio original; aquí deja de ser una línea perdida en el texto. --}}
                <div class="rounded-tarjeta border border-azafran/30 bg-azafran/5 p-7 lg:p-9">
                    <p class="font-display text-2xl font-semibold text-tinta sm:text-3xl">
                        Le realizamos una auditoría de seguridad <span class="text-azafran-oscuro">¡GRATIS *!</span>
                    </p>
                    <p class="mt-3 max-w-2xl text-tenue">
                        Estudiamos su empresa, determinamos los riesgos que tiene —internos y externos— y le
                        entregamos un informe con las medidas que debe adoptar.
                    </p>
                    <a href="{{ route('contacto') }}"
                       class="mt-6 inline-flex items-center gap-2 rounded-boton bg-azafran px-5 py-3
                             font-medium text-sobre-azafran transition hover:bg-azafran-fuerte">
                        Pedir la auditoría
                        <x-icono nombre="flecha" class="h-4 w-4"/>
                    </a>
                </div>

                <div class="mt-12">
                    <p>
                        La seguridad de los datos de una empresa es algo fundamental, de ahí la importancia
                        de poner los medios y mecanismos necesarios para evitar dicho agujero.
                    </p>

                    <p>
                        VS Informática realizará un estudio de su empresa con el objetivo de determinar
                        cuáles son los riesgos de seguridad que tiene, tanto internos como externos. Una vez
                        realizado el estudio, le redactaremos un informe indicándole las medidas hardware y
                        software que debe de adoptar para proteger a su empresa.
                    </p>

                    <p class="pregunta">¿sabía que...?</p>
                    <p>
                        el número de ataques cibernéticos a empresas aumenta de forma exponencial año tras año.
                    </p>

                    <p class="pregunta">¿para qué quieren entrar a mi empresa?</p>
                    <p>
                        el robo de información de su negocio puede ser muy valioso para mafias organizadas,
                        o simplemente los equipos de su empresa servirán como plataforma «dormida» para
                        realizar futuros ataques.
                    </p>
                </div>
            </div>

            <aside class="space-y-4 lg:pt-2">
                <figure class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta">
                    <img src="{{ asset('images/servicios/cloud.jpg') }}"
                         alt="Seguridad informática y auditoría de VS Informática"
                         width="244" height="241" loading="lazy"
                         class="w-full object-cover">
                </figure>

                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                    <p class="etiqueta text-[11px] text-tenue">Lo que protegemos</p>
                    <ul class="mt-4 space-y-3 text-sm text-tinta">
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="escudo" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Auditoría de seguridad gratuita
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="llave" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Análisis de riesgos internos y externos
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="copia" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Informe con medidas hardware y software
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="servidor" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Protección frente a ransomware y fugas
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>

    <x-cta-contacto />

</x-layouts.base>
