<x-layouts.base :titulo="$servicio['meta_titulo']" :descripcion="$servicio['meta_descripcion']">

    <x-cabecera-pagina
        :titular="$servicio['titular']"
        entradilla="Protégase."
        entradilla2="Mantenga todos sus datos críticos fuera de su empresa."
        :migas="$migas"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-[1fr_20rem]">

            <div class="prosa">
                <h2>Sus datos críticos seguros</h2>

                <p>
                    El servicio de Copia de Seguridad Remota permite recuperar información crítica ante
                    situaciones de robo, desastre (inundaciones, incendio…), hackers, virus o
                    simplemente rotura de los equipos que almacenan la información. La pérdida de
                    información en estos casos puede suponer un desastre para la empresa si no dispone
                    de un sistema de copias de seguridad robusto.
                </p>

                <p>
                    Por eso el Servicio de Copia de Seguridad Cloud de VS Informática le permite
                    salvaguardar sus archivos más importantes, depositándolos periódicamente en el Data
                    Center de VS Informática y de manera programada, a través de Internet.
                </p>

                <x-faq class="mt-10" :preguntas="[
                    [
                        'pregunta' => '¿tengo que hacer las copias manualmente?',
                        'respuesta' => 'No, puede estar tranquilo: se trata de un proceso automático. Nuestros '
                                     . 'técnicos le dejarán configurado y funcionando el sistema de back-up.',
                    ],
                    [
                        'pregunta' => '¿cuándo se realizarán las copias?',
                        'respuesta' => 'La frecuencia del back-up será la que a usted más le convenga: por horas, '
                                     . 'diarias, semanales, etc.',
                    ],
                    [
                        'pregunta' => '¿cuánto tiempo tardarán en hacerse las copias de seguridad?',
                        'respuesta' => [
                            'Depende de varios factores; los principales son la velocidad de subida de su ADSL y '
                            . 'la cantidad de información que desee almacenar fuera.',
                            'El primer back-up es el que más tiempo tarda en realizarse. A partir del segundo, las '
                            . 'copias se realizarán con la máxima rapidez y eficacia, pues empleamos técnicas '
                            . 'diferenciales (sólo guarda los cambios efectuados sobre el back-up anterior).',
                        ],
                    ],
                    [
                        'pregunta' => '¿cuántas copias de seguridad retengo fuera?',
                        'respuesta' => 'El número de copias que mantendrá en la nube dependerá de la cantidad de '
                                     . 'almacenamiento contratado.',
                    ],
                ]"/>
            </div>

            <aside class="space-y-4 lg:pt-2">
                <figure class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta">
                    <img src="{{ asset('images/servicios/cloud.jpg') }}"
                         alt="Copias de seguridad en la nube de VS Informática"
                         width="244" height="241" loading="lazy"
                         class="w-full object-cover">
                </figure>

                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                    <p class="etiqueta text-[11px] text-tenue">Lo que garantizamos</p>
                    <ul class="mt-4 space-y-3 text-sm text-tinta">
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="copia" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Backups automáticos programados
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="escudo" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Almacenamiento en Data Center español
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="llave" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Cifrado de extremo a extremo
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="globo" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Recuperación ante desastres y ransomware
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>

    <x-cta-contacto />

</x-layouts.base>
