@php
    $empresa = config('empresa');
    $direccion = $empresa['direccion'];
@endphp

<x-layouts.base
    titulo="Política de privacidad"
    descripcion="Cómo trata VS Informática La Roda S.L. los datos personales, conforme al RGPD y a la LOPDGDD 3/2018.">

    <x-cabecera-pagina
        titular="Política de privacidad"
        entradilla="Qué datos recogemos, para qué, cuánto tiempo los guardamos y qué puedes hacer al respecto."
        :migas="[
            ['titulo' => 'Inicio', 'url' => route('home')],
            ['titulo' => 'Privacidad', 'url' => null],
        ]"/>

    <div class="contenedor py-14 lg:py-20">

        {{--
            El sitio anterior citaba la Ley Orgánica 15/1999, derogada en 2018.
            Este texto está reescrito conforme al RGPD (Reglamento UE 2016/679)
            y a la LOPDGDD 3/2018, que son las que aplican hoy.
        --}}
        <div class="prosa">

            <h2>Responsable del tratamiento</h2>
            <ul>
                <li><strong>Titular:</strong> {{ $empresa['razon_social'] }}</li>
                <li><strong>CIF:</strong> {{ $empresa['cif'] }}</li>
                <li><strong>Domicilio:</strong> {{ $direccion['calle'] }}, {{ $direccion['cp'] }}
                    {{ $direccion['localidad'] }} ({{ $direccion['provincia'] }})</li>
                <li><strong>Teléfono:</strong> {{ $empresa['telefono']['legible'] }}</li>
                <li><strong>Email:</strong>
                    <a href="mailto:{{ $empresa['email'] }}">{{ $empresa['email'] }}</a></li>
            </ul>

            <h2>Qué datos tratamos y con qué finalidad</h2>
            <p>
                Solo tratamos los datos que nos facilitas voluntariamente a través del formulario de
                contacto de esta web: <strong>nombre, empresa (opcional), teléfono, email y el
                mensaje</strong> que escribes. Junto a ellos guardamos la fecha en que aceptaste esta
                política y la dirección IP desde la que lo hiciste, porque el RGPD nos exige poder
                demostrar que ese consentimiento existió.
            </p>
            <p>
                La finalidad es <strong>atender tu solicitud de información y ponernos en contacto
                contigo</strong>. Nada más. No elaboramos perfiles, no tomamos decisiones
                automatizadas y no te enviamos comunicaciones comerciales que no hayas pedido.
            </p>

            <h2>Base jurídica</h2>
            <p>
                El <strong>consentimiento</strong> que otorgas al marcar la casilla del formulario
                (art. 6.1.a RGPD). Si ya eres cliente, el tratamiento se ampara además en la
                <strong>ejecución del contrato</strong> que nos une (art. 6.1.b RGPD).
            </p>
            <p>
                Facilitar los datos marcados como obligatorios es necesario para poder atenderte: si
                no nos los das, no podremos responderte.
            </p>

            <h2>Plazo de conservación</h2>
            <p>
                Las consultas recibidas por el formulario se conservan un <strong>máximo de un
                año</strong> desde su recepción, y se eliminan automáticamente al cumplirse ese
                plazo. Si de la consulta nace una relación comercial, los datos se conservarán
                mientras dure y, después, durante los plazos legalmente exigidos en materia fiscal y
                mercantil.
            </p>

            <h2>Destinatarios</h2>
            <p>
                <strong>No cedemos tus datos a terceros</strong> ni realizamos transferencias
                internacionales. Los únicos accesos posibles son los de los proveedores que nos
                prestan servicios de alojamiento y correo electrónico, que actúan como encargados del
                tratamiento con contrato firmado conforme al art. 28 del RGPD.
            </p>

            <h2>Tus derechos</h2>
            <p>
                Puedes ejercer en cualquier momento los derechos de <strong>acceso, rectificación,
                supresión, limitación del tratamiento, oposición y portabilidad</strong>, así como
                retirar el consentimiento prestado, sin que ello afecte a la licitud del tratamiento
                previo a su retirada.
            </p>
            <p>
                Para ello escribe a
                <a href="mailto:{{ $empresa['email'] }}">{{ $empresa['email'] }}</a>
                o por correo postal a {{ $direccion['calle'] }}, {{ $direccion['cp'] }}
                {{ $direccion['localidad'] }} ({{ $direccion['provincia'] }}), indicando qué derecho
                deseas ejercer y adjuntando copia de tu documento de identidad.
            </p>

            <h2>Reclamación ante la autoridad de control</h2>
            <p>
                Si consideras que el tratamiento de tus datos no se ajusta a la normativa, tienes
                derecho a presentar una reclamación ante la
                <strong>Agencia Española de Protección de Datos</strong>
                (<a href="https://www.aepd.es" target="_blank" rel="noopener noreferrer">www.aepd.es</a>),
                C/ Jorge Juan 6, 28001 Madrid.
            </p>

            <h2>Seguridad</h2>
            <p>
                Aplicamos las medidas técnicas y organizativas necesarias para garantizar la
                seguridad de los datos y evitar su alteración, pérdida, tratamiento o acceso no
                autorizado, conforme al art. 32 del RGPD.
            </p>

            <h2>Normativa aplicable</h2>
            <ul>
                <li>Reglamento (UE) 2016/679, General de Protección de Datos (RGPD).</li>
                <li>Ley Orgánica 3/2018, de 5 de diciembre, de Protección de Datos Personales y
                    garantía de los derechos digitales (LOPDGDD).</li>
                <li>Ley 34/2002, de Servicios de la Sociedad de la Información y de Comercio
                    Electrónico (LSSI-CE).</li>
            </ul>
        </div>
    </div>

</x-layouts.base>
