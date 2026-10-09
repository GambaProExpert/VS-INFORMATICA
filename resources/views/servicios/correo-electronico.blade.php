<x-layouts.base :titulo="$servicio['meta_titulo']" :descripcion="$servicio['meta_descripcion']">

    <x-cabecera-pagina
        :titular="$servicio['titular']"
        entradilla="¿Quieres tener cuentas de correo propias?"
        entradilla2="Nosotros te lo adaptamos."
        :migas="$migas"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-[1fr_20rem]">

            <div class="prosa">
                <h2>Correo empresarial con su dominio</h2>

                <p>
                    ¿Quieres tener cuentas de correo propias? Nosotros te lo adaptamos.
                    Te asesoramos sobre la configuración que mejor se adapta a tu empresa.
                </p>

                <x-faq :preguntas="[
                    [
                        'pregunta' => '¿cómo configuro mi correo, imap o pop3?',
                        'respuesta' => 'La configuración de una cuenta depende de las necesidades de la empresa. '
                                     . 'Para aquellos usuarios que necesiten tener sincronizados sus correos en dos '
                                     . 'o más dispositivos, la opción ideal es <strong>IMAP</strong>; y para aquellos '
                                     . 'que sólo tengan su cuenta configurada en un único puesto, o no les interese '
                                     . 'tener sincronizados los correos salientes, les aconsejamos <strong>POP3</strong>.',
                    ],
                ]"/>

                {{-- Comparativa rápida: la pregunta de arriba se responde mejor viendo
                     las dos opciones una al lado de la otra. --}}
                <div class="mt-8 grid gap-5 sm:grid-cols-2">
                    <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                        <p class="text-sm font-medium text-tinta">IMAP</p>
                        <p class="mt-2 text-[15px] leading-relaxed text-tenue">
                            El correo vive en el servidor y se sincroniza en todos los dispositivos. Si borras
                            un mensaje en el móvil, desaparece también del ordenador.
                        </p>
                        <p class="mt-3 etiqueta text-xs text-azafran-oscuro">
                            Para quien usa dos o más dispositivos
                        </p>
                    </div>

                    <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                        <p class="text-sm font-medium text-tinta">POP3</p>
                        <p class="mt-2 text-[15px] leading-relaxed text-tenue">
                            El correo se descarga al equipo y deja de estar en el servidor. Ocupa menos espacio
                            en la nube, pero solo lo tienes en ese puesto.
                        </p>
                        <p class="mt-3 etiqueta text-xs text-azafran-oscuro">
                            Para quien trabaja en un solo puesto
                        </p>
                    </div>
                </div>

                <p class="mt-8 font-display text-xl font-medium text-tinta">
                    Usted no se preocupe, nosotros le aconsejaremos.
                </p>
            </div>

            <aside class="space-y-4 lg:pt-2">
                <figure class="overflow-hidden rounded-tarjeta border border-linea bg-tarjeta">
                    <img src="{{ asset('images/servicios/cloud.jpg') }}"
                         alt="Correo empresarial en la nube de VS Informática"
                         width="244" height="241" loading="lazy"
                         class="w-full object-cover">
                </figure>

                <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                    <p class="etiqueta text-[11px] text-tenue">Lo que incluye</p>
                    <ul class="mt-4 space-y-3 text-sm text-tinta">
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="sobre" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Cuentas IMAP/POP3 con su dominio
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="escudo" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Antispam y antivirus integrados
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="copia" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Sincronización en todos sus dispositivos
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-icono nombre="llave" class="mt-0.5 h-4 w-4 shrink-0 text-azafran"/>
                            Configuración y soporte incluido
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>

    <x-cta-contacto texto="No lo dude, llámenos, estaremos encantados de hablar con usted"/>

</x-layouts.base>
