<x-layouts.base :titulo="$servicio['meta_titulo']" :descripcion="$servicio['meta_descripcion']">

    <x-cabecera-pagina
        :titular="$servicio['titular']"
        entradilla="Somos expertos en montajes de Redes,"
        entradilla2="Servidores Windows Server e interconexión de sucursales."
        :migas="$migas"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-[1fr_20rem]">

            <div class="prosa">
                <h2>Hardware, Software y Configuración PROFESIONAL</h2>

                <p class="pregunta">¿qué es esto...?</p>

                <p>
                    A lo largo de estos años hemos visto «casi de todo», desde un PC «barato»
                    haciendo de servidor, hasta…
                </p>

                <p>
                    Si usted tiene una empresa «pequeña, mediana o grande», hágase las siguientes
                    preguntas… <strong>¿quiero…</strong>
                </p>

                <ul>
                    <li>tener mis datos centralizados?</li>
                    <li>que mis usuarios no puedan acceder a determinados recursos de mi empresa?</li>
                    <li>compartir impresoras, carpetas, archivos?</li>
                    <li>tener copias de seguridad de los datos de todos mis equipos?</li>
                    <li>que mis datos sean totalmente confidenciales?</li>
                </ul>

                <p>
                    … si ha contestado afirmativamente a alguna o todas estas preguntas, usted
                    necesita tener su <strong>red estructurada</strong>.
                </p>

                <p class="pregunta">¿qué es una red estructurada?</p>

                <p>
                    De modo muy sencillo, una red estructurada consta de «un servidor», «un switch»
                    y «puestos informáticos». Todo ello acompañado de un Sistema Operativo potente
                    y estable.
                </p>

                <p>
                    Leyendo el párrafo anterior, usted podrá pensar que su empresa tiene todo esto,
                    por lo tanto cumple el concepto de estructuración. <strong>¡FALLO!</strong>,
                    esta respuesta «equivocada» la tienen muchas empresas: la estructuración se
                    compone de «HARDWARE de CALIDAD», de «SOFTWARE» y de una «PROGRAMACIÓN y
                    CONFIGURACIÓN de CALIDAD».
                </p>

                <p>
                    VS Informática tiene los técnicos y medios necesarios para realizar la
                    infraestructura de su red con «CALIDAD».
                </p>
            </div>

            <aside class="lg:pt-2">
                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                    <p class="etiqueta text-[11px] text-tenue">
                        Lo que montamos
                    </p>
                    <ul class="mt-4 space-y-3 text-sm text-tinta">
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="servidor" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Servidores Windows Server
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="red" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Redes estructuradas y switches
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="globo" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Interconexión de sucursales por VPN
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="escudo" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Permisos y confidencialidad de los datos
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>

    <x-cta-contacto />

</x-layouts.base>
