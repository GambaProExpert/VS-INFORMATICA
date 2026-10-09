<x-layouts.base
    titulo="Soporte remoto"
    descripcion="Descarga el cliente de asistencia remota de VS Informática y llámanos al 967 44 51 53:
                 muchas incidencias se resuelven en la misma llamada.">

    <x-cabecera-pagina
        titular="Soporte remoto"
        entradilla="Descarga el programa, llámanos y nos conectamos a tu equipo."
        entradilla2="Sin instalar nada permanente y solo mientras dure la llamada."
        :migas="[
            ['titulo' => 'Inicio', 'url' => route('home')],
            ['titulo' => 'Soporte', 'url' => null],
        ]"/>

    <div class="contenedor py-14 lg:py-20">

        {{-- Cómo funciona: en el sitio original estas descargas estaban sueltas
             en la barra superior, sin una sola línea que explicara qué hacer
             con ellas. --}}
        <ol data-anim="lista" class="grid gap-5 sm:grid-cols-3">
            @foreach ([
                ['n' => '1', 'titulo' => 'Llámanos', 'texto' => 'Marca el ' . config('empresa.telefono.legible')
                    . ' y cuéntanos qué te pasa. Si se puede ver en remoto, te lo decimos.'],
                ['n' => '2', 'titulo' => 'Descarga el programa', 'texto' => 'Elige abajo el que corresponda a tu equipo. '
                    . 'No se instala: se ejecuta y ya está.'],
                ['n' => '3', 'titulo' => 'Danos el código', 'texto' => 'El programa te muestra un ID y una contraseña. '
                    . 'Nos los dictas por teléfono y entramos.'],
            ] as $paso)
                <li class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-azafran/10
                                 text-sm font-medium text-azafran-oscuro">
                        {{ $paso['n'] }}
                    </span>
                    <h2 class="mt-4 font-display text-lg font-semibold text-tinta">{{ $paso['titulo'] }}</h2>
                    <p class="mt-2 text-[15px] leading-relaxed text-tenue">{{ $paso['texto'] }}</p>
                </li>
            @endforeach
        </ol>

        <section class="mt-14">
            <h2 class="font-display text-2xl font-semibold tracking-tight text-tinta sm:text-3xl">
                Descargas
            </h2>

            <ul data-anim="lista" class="mt-6 space-y-4">
                @foreach (config('empresa.soporte_remoto') as $descarga)
                    <li @class([
                        'rounded-tarjeta border bg-tarjeta p-6',
                        'border-azafran/40 ring-1 ring-azafran/20' => $descarga['destacado'],
                        'border-linea' => ! $descarga['destacado'],
                    ])>
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-start gap-4">
                                <span class="mt-0.5 shrink-0 rounded-boton border border-linea bg-niebla p-2.5">
                                    <x-icono :nombre="$descarga['icono']" class="h-5 w-5 text-tinta"/>
                                </span>
                                <div>
                                    <h3 class="flex flex-wrap items-center gap-2 font-display text-lg font-semibold text-tinta">
                                        {{ $descarga['nombre'] }}
                                        @if ($descarga['destacado'])
                                            <span class="etiqueta rounded-full bg-azafran/10 px-2 py-0.5
                                                         text-[10px] text-azafran-oscuro">
                                                El habitual
                                            </span>
                                        @endif
                                    </h3>
                                    <p class="mt-1 max-w-xl text-[15px] text-tenue">{{ $descarga['descripcion'] }}</p>
                                    <p class="mt-1.5 etiqueta text-xs text-tenue">
                                        {{ $descarga['sistema'] }}
                                    </p>
                                </div>
                            </div>

                            <a href="{{ $descarga['url'] }}"
                               rel="noopener noreferrer"
                               @class([
                                   'inline-flex shrink-0 items-center justify-center gap-2 rounded-boton px-5 py-2.5 text-sm font-medium transition',
                                   'bg-azafran text-sobre-azafran hover:bg-azafran-fuerte' => $descarga['destacado'],
                                   'border border-linea text-tinta hover:border-linea-fuerte' => ! $descarga['destacado'],
                               ])>
                                <x-icono nombre="descarga" class="h-4 w-4"/>
                                Descargar
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>

            <p class="mt-6 max-w-2xl text-sm text-tenue">
                Estas descargas se sirven desde TeamViewer e ISL Online, que son sus fabricantes.
                Nosotros no podemos conectarnos a tu equipo sin que tú ejecutes el programa y nos
                des el código: en cuanto lo cierras, se acabó el acceso.
            </p>
        </section>
    </div>

    <x-cta-contacto
        texto="¿No sabes cuál descargar? Llámanos y te lo decimos nosotros."
        boton="Escríbenos"/>

</x-layouts.base>
