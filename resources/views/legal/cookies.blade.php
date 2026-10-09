<x-layouts.base
    titulo="Política de cookies"
    descripcion="Qué cookies usa vsinformatica.es y cómo gestionarlas.">

    <x-cabecera-pagina
        titular="Política de cookies"
        entradilla="Qué guardamos en tu navegador y por qué."
        :migas="[
            ['titulo' => 'Inicio', 'url' => route('home')],
            ['titulo' => 'Cookies', 'url' => null],
        ]"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="prosa">

            <h2>Qué es una cookie</h2>
            <p>
                Una cookie es un pequeño fichero que un sitio web guarda en tu navegador para
                recordar información entre visitas. Algunas son imprescindibles para que la web
                funcione; otras sirven para medir o para publicidad.
            </p>

            <h2>Qué usamos en esta web</h2>
            <p>
                Muy poco, y a propósito. Esta web <strong>no usa cookies de analítica ni de
                publicidad</strong>, no incrusta vídeos de terceros y no carga tipografías desde
                servidores externos: las tres fuentes se sirven desde nuestro propio dominio, así que
                tu dirección IP no viaja a ningún CDN.
            </p>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[36rem] border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-linea text-left">
                            <th class="py-3 pr-4 etiqueta text-[11px] text-tenue">Nombre</th>
                            <th class="py-3 pr-4 etiqueta text-[11px] text-tenue">Tipo</th>
                            <th class="py-3 pr-4 etiqueta text-[11px] text-tenue">Finalidad</th>
                            <th class="py-3 etiqueta text-[11px] text-tenue">Duración</th>
                        </tr>
                    </thead>
                    <tbody class="text-tenue">
                        <tr class="border-b border-linea">
                            <td class="py-3 pr-4 font-medium tabular-nums text-tinta">XSRF-TOKEN</td>
                            <td class="py-3 pr-4">Técnica propia</td>
                            <td class="py-3 pr-4">Proteger el formulario de contacto frente a envíos falsificados.</td>
                            <td class="py-3">Sesión</td>
                        </tr>
                        <tr class="border-b border-linea">
                            <td class="py-3 pr-4 font-medium tabular-nums text-tinta">vs_informatica_session</td>
                            <td class="py-3 pr-4">Técnica propia</td>
                            <td class="py-3 pr-4">Mantener el estado del formulario mientras lo rellenas.</td>
                            <td class="py-3">2 horas</td>
                        </tr>
                        <tr class="border-b border-linea">
                            <td class="py-3 pr-4 font-medium tabular-nums text-tinta">tema</td>
                            <td class="py-3 pr-4">Almacenamiento local</td>
                            <td class="py-3 pr-4">Recordar si prefieres el tema claro, el oscuro o el del sistema.</td>
                            <td class="py-3">Hasta que borres los datos del navegador</td>
                        </tr>
                        <tr>
                            <td class="py-3 pr-4 font-medium tabular-nums text-tinta">cookies</td>
                            <td class="py-3 pr-4">Almacenamiento local</td>
                            <td class="py-3 pr-4">Recordar tu decisión sobre este aviso para no volver a mostrarlo.</td>
                            <td class="py-3">Hasta que borres los datos del navegador</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p>
                Las dos últimas no son técnicamente cookies, sino almacenamiento local del navegador,
                pero las declaramos igual porque a efectos de tu privacidad hacen lo mismo: guardar
                algo en tu equipo.
            </p>

            <h2>El mapa de Google</h2>
            <p>
                En la <a href="{{ route('contacto') }}">página de contacto</a> hay un mapa de Google
                Maps que <strong>no se carga hasta que tú lo pides</strong>. Mientras no pulses «Ver
                el mapa», Google no recibe ninguna petición desde tu navegador. Si lo cargas, se
                aplicará la política de privacidad de Google.
            </p>

            <h2>Cómo gestionarlas</h2>
            <p>
                Puedes cambiar tu decisión cuando quieras desde el enlace
                <strong>«Cambiar consentimiento»</strong> del pie de página. También puedes borrar o
                bloquear cookies desde la configuración de tu navegador: Chrome, Firefox, Edge y
                Safari tienen todos una sección de privacidad para ello.
            </p>
            <p>
                Ten en cuenta que si bloqueas las cookies técnicas, el formulario de contacto dejará
                de funcionar.
            </p>
        </div>
    </div>

</x-layouts.base>
