@php
    /*
     | Las seis unidades del rack, de arriba abajo. El orden y los identificadores
     | tienen que coincidir con UNIDADES en resources/js/rack.js: el JavaScript
     | ilumina la unidad número N cuando aquí se activa el paso número N.
     |
     | No es un adorno: es el catálogo de servicios contado con el objeto que la
     | empresa monta de verdad, y cada unidad enlaza a su página.
     */
    $unidades = [
        [
            'id' => 'patch',
            'nombre' => 'Panel de parcheo',
            'titulo' => 'Cableado ordenado y etiquetado',
            'texto' => 'Todo el cableado de la empresa termina aquí, numerado y documentado. '
                     . 'Cuando algo falla se sabe qué cable es sin levantar el suelo.',
            'icono' => 'red',
            'ruta' => 'redes-y-servidores',
        ],
        [
            'id' => 'switch',
            'nombre' => 'Switch gestionable',
            'titulo' => 'La red que conecta todos los puestos',
            'texto' => 'Reparte la red entre los equipos y separa el tráfico por zonas, para que '
                     . 'la copia de seguridad no frene a quien está facturando.',
            'icono' => 'red',
            'ruta' => 'redes-y-servidores',
        ],
        [
            'id' => 'firewall',
            'nombre' => 'Cortafuegos',
            'titulo' => 'Lo que separa tu empresa de Internet',
            'texto' => 'Filtra lo que entra y lo que sale, y levanta las VPN con las que se '
                     . 'conectan las sucursales. Le hacemos una auditoría de seguridad gratis.',
            'icono' => 'escudo',
            'ruta' => 'ciberseguridad',
        ],
        [
            'id' => 'servidor',
            'nombre' => 'Servidor',
            'titulo' => 'Los datos, centralizados y con permisos',
            'texto' => 'Windows Server con las carpetas, las impresoras y los permisos de cada '
                     . 'usuario. Aquí vive a3ERP y aquí trabaja todo el mundo.',
            'icono' => 'servidor',
            'ruta' => 'hardware',
        ],
        [
            'id' => 'nas',
            'nombre' => 'Cabina de discos',
            'titulo' => 'Si mañana entra un ransomware, recuperas lo de ayer',
            'texto' => 'Copia automática de todo, con discos en caliente y una segunda copia '
                     . 'fuera de la empresa. Es la unidad que nadie mira hasta que la necesita.',
            'icono' => 'copia',
            'ruta' => 'copias-de-seguridad',
        ],
        [
            'id' => 'sai',
            'nombre' => 'SAI',
            'titulo' => 'Un corte de luz deja de ser un problema',
            'texto' => 'Da corriente el tiempo suficiente para que el servidor se apague como '
                     . 'debe. Sin él, cada apagón es una lotería con la base de datos.',
            'icono' => 'llave',
            'ruta' => 'reparacion',
        ],
    ];
@endphp

{{--
    Sección del rack 3D.

    El HTML de partida es una lista legible de los seis componentes: es lo que
    ve quien no tiene JavaScript, quien pide movimiento reducido y quien navega
    con lector de pantalla. Solo cuando Three.js consigue arrancar, el atributo
    data-rack-estado="listo" cambia la maqueta a dos columnas y aparece el 3D.

    Nunca al revés: la información no depende de que cargue una escena WebGL.
--}}
{{--
    Sin pin de ScrollTrigger, a propósito.

    Antes esta sección se fijaba y se apropiaba de 2.520 px de scroll: dos
    pantallas y media en las que la rueda del ratón no movía nada de la página
    mientras por dentro se recorría el rack. Aunque técnicamente funcionaba, lo
    que se siente es que la web se ha quedado colgada.

    Ahora el rack va con `position: sticky` y las seis tarjetas pasan por su
    lado con el scroll normal del navegador. El efecto es el mismo —el rack
    quieto, la cámara bajando, el texto cambiando— pero la página no deja de
    responder ni un solo fotograma.
--}}
<section data-rack
         data-rack-estado="texto"
         class="border-t border-linea bg-niebla
                [&[data-rack-estado=listo]_[data-rack-lienzo-caja]]:block
                [&[data-rack-estado=listo]_[data-rack-riel]]:lg:flex">

    <div class="contenedor py-16 lg:py-20">

        <div class="max-w-2xl">
            <p class="etiqueta text-[11px] text-tenue">De arriba abajo</p>
            <h2 class="mt-3 font-display text-3xl font-semibold tracking-tight text-tinta sm:text-4xl">
                Lo que hay dentro de un rack bien montado
            </h2>
            <p class="mt-3 text-tenue">
                Esto es lo que instalamos en una empresa. Baja y verás para qué sirve cada pieza.
            </p>
        </div>

        <div class="mt-10 grid gap-10 lg:grid-cols-[minmax(0,26rem)_minmax(0,1fr)] lg:gap-16">

            {{-- El lienzo se queda pegado mientras pasan las tarjetas. Se
                 estrecha a propósito: un rack es mucho más alto que ancho, y en
                 una caja apaisada se queda diminuto en medio de fondo vacío. --}}
            <div data-rack-lienzo-caja
                 class="mx-auto hidden w-full max-w-[17rem] sm:max-w-[22rem]
                        lg:sticky lg:top-28 lg:self-start">
                <div class="relative h-[58vh] w-full overflow-hidden rounded-tarjeta
                            border border-linea bg-tarjeta">
                    <canvas data-rack-lienzo class="h-full w-full"></canvas>
                </div>
            </div>

            <div class="flex gap-6">
                {{-- Raíl de progreso: seis marcas, una por unidad. Se queda
                     centrado en pantalla junto al rack. Solo aparece con el 3D
                     montado, porque sin él la lista ya se ve entera. --}}
                <ol data-rack-riel
                    class="hidden shrink-0 flex-col gap-2
                           lg:sticky lg:top-1/2 lg:h-fit lg:-translate-y-1/2 lg:self-start"
                    aria-hidden="true">
                    @foreach ($unidades as $i => $unidad)
                        <li data-rack-marca="{{ $i }}"
                            class="h-6 w-0.5 rounded-full bg-linea-fuerte transition-all duration-300"></li>
                    @endforeach
                </ol>

                {{-- Las seis tarjetas, en flujo normal.
                     En escritorio cada una ocupa su propia altura de pantalla y
                     se centra dentro: así el hueco entre tarjetas no es un vacío
                     suelto, sino el sitio que le toca a cada una mientras el
                     rack de al lado se queda quieto. --}}
                <ol data-rack-pasos class="min-w-0 flex-1 space-y-6 lg:space-y-0">
                    @foreach ($unidades as $i => $unidad)
                        <li data-rack-paso
                            data-activo="{{ $i === 0 ? 'si' : 'no' }}"
                            class="rounded-tarjeta border border-linea bg-tarjeta p-6
                                   transition-all duration-500
                                   data-[activo=si]:border-azafran/45
                                   data-[activo=si]:shadow-suave
                                   lg:my-[18vh] lg:data-[activo=no]:opacity-40">

                            <div class="flex items-start gap-4">
                                <span class="shrink-0 rounded-boton border border-linea bg-niebla p-2.5">
                                    <x-icono :nombre="$unidad['icono']" class="h-5 w-5 text-azafran"/>
                                </span>

                                <div class="min-w-0">
                                    <p class="etiqueta text-[11px] text-azafran-oscuro">
                                        {{ $unidad['nombre'] }}
                                        <span class="text-tenue">· {{ $i + 1 }}/{{ count($unidades) }}</span>
                                    </p>
                                    <h3 class="mt-1.5 font-display text-lg font-semibold leading-snug text-tinta">
                                        {{ $unidad['titulo'] }}
                                    </h3>
                                    <p class="mt-2 text-[15px] leading-relaxed text-tenue">
                                        {{ $unidad['texto'] }}
                                    </p>
                                    <a href="{{ route('servicios.show', $unidad['ruta']) }}"
                                       class="group mt-3 inline-flex items-center gap-1.5 font-medium text-sm
                                              text-azafran-oscuro underline-offset-4 hover:underline">
                                        Ver el servicio
                                        <x-icono nombre="flecha"
                                                 class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5"/>
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</section>
