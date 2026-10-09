@php
    $empresa = config('empresa');
    $direccion = $empresa['direccion'];
@endphp

<x-layouts.base
    titulo="Aviso legal"
    descripcion="Aviso legal de VS Informática La Roda S.L. conforme a la LSSI-CE.">

    <x-cabecera-pagina
        titular="Aviso legal"
        entradilla="Datos identificativos y condiciones de uso de este sitio web."
        :migas="[
            ['titulo' => 'Inicio', 'url' => route('home')],
            ['titulo' => 'Aviso legal', 'url' => null],
        ]"/>

    <div class="contenedor py-14 lg:py-20">
        <div class="prosa">

            <h2>Objeto del sitio web</h2>
            <p>
                El presente sitio web tiene un carácter meramente informativo, no constituyendo en
                ningún caso un medio de asesoramiento sobre ninguna de las áreas especificadas en el
                mismo, para lo cual el usuario deberá dirigirse a:
            </p>

            <div class="rounded-tarjeta border border-linea bg-tarjeta p-6">
                <address class="space-y-1 not-italic text-[15px] text-tinta">
                    <p class="font-medium">{{ $empresa['razon_social'] }}</p>
                    <p class="text-tenue">{{ $direccion['calle'] }}</p>
                    <p class="text-tenue">
                        {{ $direccion['cp'] }} {{ $direccion['localidad'] }} ({{ $direccion['provincia'] }})
                    </p>
                    <p class="pt-2">
                        Teléfono:
                        <a href="tel:{{ $empresa['telefono']['e164'] }}"
                           class="font-sans font-medium tabular-nums text-azafran-oscuro underline underline-offset-2">
                            {{ $empresa['telefono']['legible'] }}
                        </a>
                    </p>
                    <p>
                        Email:
                        <a href="mailto:{{ $empresa['email'] }}"
                           class="text-azafran-oscuro underline underline-offset-2">{{ $empresa['email'] }}</a>
                    </p>
                    <p class="pt-2 text-sm text-tenue">{{ $empresa['registro'] }}</p>
                    <p class="text-sm text-tenue">CIF: {{ $empresa['cif'] }}</p>
                </address>
            </div>

            <h2>Contenido del sitio web</h2>
            <p>
                La información incluida en el sitio web ha seguido los requerimientos pedidos por la
                Ley, pero de ninguna forma eso implica que tenga que estar necesariamente detallada,
                completa, exacta o mantenerse actualizada, debido en su caso a las variaciones que
                puedan producirse en la normativa, jurisprudencia u otros documentos de interés
                considerados.
            </p>
            <p>
                La utilización de la información proporcionada a través de este sitio web es
                responsabilidad exclusiva del usuario, no siendo {{ $empresa['razon_social'] }} en
                ningún caso responsable de los errores u omisiones que pudieran existir, así como de
                la aplicación o uso concreto que pueda hacerse de la misma.
            </p>

            <h2>Datos de carácter personal</h2>
            <p>
                El tratamiento de los datos personales que se recojan a través de este sitio web se
                rige por el Reglamento (UE) 2016/679 (RGPD) y la Ley Orgánica 3/2018, de Protección
                de Datos Personales y garantía de los derechos digitales. Puede consultar el detalle
                en nuestra
                <a href="{{ route('legal.privacidad') }}">política de privacidad</a>.
            </p>

            <h2>Enlaces</h2>
            <p>
                {{ $empresa['razon_social'] }} no asume ninguna responsabilidad sobre los enlaces
                hacia otros sitios o páginas web que, en su caso, pudieran incluirse en el mismo, ya
                que no tiene ningún tipo de control sobre los mismos, por lo que el usuario accede
                bajo su exclusiva responsabilidad al contenido y en las condiciones de uso que rijan
                en los mismos.
            </p>

            <h2>Propiedad intelectual e industrial</h2>
            <p>
                Esta página web contiene imágenes, logotipos, etc., con derecho de autor, siendo
                únicamente propiedad de dicho autor, como son Intel, A3 Software, Avast Antivirus,
                Zyxel, HP y Western Digital, entre otras. Las marcas citadas se emplean únicamente
                para identificar los productos y servicios de los que somos distribuidores o partner
                autorizados.
            </p>

            <h3>Créditos de las imágenes</h3>
            <p>
                Parte de las imágenes empleadas en versiones anteriores de este sitio proceden de
                Fotolia, con las siguientes atribuciones:
            </p>
            <ul>
                <li>© pokki — Fotolia.com</li>
                <li>© Sergey Ilin — Fotolia.com</li>
                <li>© teracreonte — Fotolia.com</li>
                <li>© valdis torms — Fotolia.com</li>
                <li>© julien tromeur — Fotolia.com</li>
                <li>© daboost — Fotolia.com</li>
            </ul>

            <h2>Legislación aplicable</h2>
            <p>
                El presente aviso legal se rige por la legislación española, en particular por la Ley
                34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y de Comercio
                Electrónico (LSSI-CE).
            </p>
        </div>
    </div>

</x-layouts.base>
