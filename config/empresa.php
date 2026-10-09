<?php

/*
|--------------------------------------------------------------------------
| Datos de VS Informática La Roda S.L.
|--------------------------------------------------------------------------
|
| Fuente única de verdad para el pie, el aviso legal, los datos estructurados
| de schema.org y la barra de estado. Todos estos valores están verificados
| contra el sitio original (vsinformatica.es).
|
| Si cambia el horario, se cambia AQUÍ: la barra de estado y el schema.org
| leen de la misma clave, así que no pueden divergir.
|
*/

return [

    'nombre'        => 'VS Informática',
    'nombre_largo'  => 'VS Informática La Roda',
    'razon_social'  => 'VS INFORMÁTICA LA RODA S.L.',
    'cif'           => 'B-02340677',
    'fundacion'     => 1997,

    'registro' => 'Inscrita en el Registro Mercantil de Albacete. Tomo 748, Libro 512, '
                 . 'Secc. 8, Folio 76, Hoja AB-12093, Inscrip. 1ª',

    'direccion' => [
        'calle'     => 'C/ Puerta de Granada, 39 Local',
        'localidad' => 'La Roda',
        'provincia' => 'Albacete',
        'cp'        => '02630',
        'pais'      => 'ES',
    ],

    // El teléfono se escribe una vez y se formatea donde haga falta.
    'telefono' => [
        'e164'      => '+34967445153',   // para href="tel:"
        'legible'   => '967 44 51 53',   // para mostrar
    ],

    'email' => 'lopd@vsinformatica.es',

    'redes' => [
        'facebook' => 'https://www.facebook.com/vsinformaticalaroda',
    ],

    /*
     | Horario real: jornada partida de lunes a viernes.
     | Ojo: el sitio original solo lo publicaba en /contacto.html.
     */
    'horario' => [
        'dias'   => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
        'tramos' => [
            ['abre' => '09:30', 'cierra' => '13:30'],
            ['abre' => '16:30', 'cierra' => '19:00'],
        ],
        'texto' => 'De lunes a viernes: 09:30 – 13:30 y 16:30 – 19:00',
    ],

    'zona_horaria' => 'Europe/Madrid',

    // Coordenadas de La Roda (Albacete). Ajustar al portal exacto si se afina.
    'geo' => ['lat' => 39.2069, 'lng' => -2.1578],

    'zonas_servicio' => ['La Roda', 'Albacete', 'Villarrobledo', 'Tarazona de la Mancha'],

    /*
     | Partners oficiales. El sitio original los muestra en una franja del pie
     | y los cita en el aviso legal.
     */
    'partners' => [
        ['nombre' => 'Intel',          'logo_claro' => 'intel.png',         'logo_oscuro' => 'intel.png'],
        ['nombre' => 'HP',             'logo_claro' => 'hp.png',            'logo_oscuro' => 'hp.png'],
        ['nombre' => 'a3ERP',          'logo_claro' => 'a3.png',            'logo_oscuro' => 'a3.png'],
        ['nombre' => 'Western Digital','logo_claro' => 'wd.png',            'logo_oscuro' => 'wd.png'],
        ['nombre' => 'ESET',           'logo_claro' => 'eset-distribuidor.jpg', 'logo_oscuro' => 'eset.png'],
        ['nombre' => 'Zyxel',          'logo_claro' => 'zyxel.png',         'logo_oscuro' => 'zyxel.png'],
    ],

    /*
     | Descargas de asistencia remota. En el sitio original solo vivían en la
     | barra superior; ahora tienen página propia en /soporte.
     */
    'soporte_remoto' => [
        [
            'nombre'      => 'Soporte 15',
            'descripcion' => 'TeamViewer QuickSupport para Windows de 64 bits. Es el que usamos normalmente.',
            'url'         => 'https://download.teamviewer.com/download/TeamViewerQS_x64.exe',
            'sistema'     => 'Windows 64 bits',
            'icono'       => 'windows',
            'destacado'   => true,
        ],
        [
            'nombre'      => 'Soporte 15 (Legacy)',
            'descripcion' => 'La misma versión, servida desde nuestro propio servidor. Úsalo si el enlace anterior falla.',
            'url'         => 'https://www.vsinformatica.es/soportevs/TeamViewerQS__15.exe',
            'sistema'     => 'Windows',
            'icono'       => 'windows',
            'destacado'   => false,
        ],
        [
            'nombre'      => 'Soporte ISL',
            'descripcion' => 'ISL Light Client. Alternativa cuando TeamViewer no puede conectar.',
            'url'         => 'https://islonline.net/start/ISLLightClient',
            'sistema'     => 'Multiplataforma',
            'icono'       => 'globo',
            'destacado'   => false,
        ],
        [
            'nombre'      => 'Soporte Mac',
            'descripcion' => 'TeamViewer QuickSupport para macOS.',
            'url'         => 'https://download.teamviewer.com/download/TeamViewerQS.dmg',
            'sistema'     => 'macOS',
            'icono'       => 'apple',
            'destacado'   => false,
        ],
    ],

];
