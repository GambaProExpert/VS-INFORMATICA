<?php

/*
|--------------------------------------------------------------------------
| Catálogo de servicios
|--------------------------------------------------------------------------
|
| Fuente única de verdad del contenido. De aquí comen el menú desplegable,
| las tarjetas de la home, los índices de sección, las migas de pan, el mapa
| del sitio y el sitemap.xml. Añadir un servicio es añadir una entrada aquí
| más su vista en resources/views/servicios/{slug}.blade.php.
|
| Los 'titular' y 'entradilla' son los textos ORIGINALES de vsinformatica.es,
| copiados palabra por palabra (solo se han corregido erratas evidentes).
| Los 'meta_*' sí son nuevos: el sitio original repetía la misma descripción
| en las 17 páginas.
|
| El día que la empresa quiera editar el contenido, se sustituye este fichero
| por un modelo Eloquent y se reescribe App\Contenido\Servicios: las vistas
| no se enteran.
|
*/

return [

    'software-gestion-a3erp' => [
        'orden'          => 1,
        'nav'            => 'Software',
        'nav_subtitulo'  => 'Gestión Empresarial',
        'titulo'         => 'a3ERP',
        'titular'        => 'a3ERP',
        'entradilla'     => 'Solución integral de gestión para PYMES',
        'entradilla_2'   => 'Más y mayor eficiencia, más facilidad.',
        'icono'          => 'software',
        'imagen'         => 'images/home/a3erp.jpg',
        'imagen_alt'     => 'Pantalla de a3ERP, el software de gestión empresarial que implanta VS Informática',
        'meta_titulo'    => 'Distribuidor a3ERP en Albacete | Implantación y soporte',
        'meta_descripcion' => 'Distribuidores Partner Associate de a3ERP en La Roda y Albacete. '
                            . 'Factura, controla el almacén y lleva la contabilidad desde un solo programa.',
        'destacado'      => true,
        'hijos'          => [],
    ],

    'hardware' => [
        'orden'          => 2,
        'nav'            => 'Hardware',
        'nav_subtitulo'  => 'Infraestructura',
        'titulo'         => 'Hardware',
        'titular'        => 'Hardware',
        'entradilla'     => 'Tu empresa nunca para,',
        'entradilla_2'   => 'por ello ofrecemos servicios hardware de más alto nivel',
        'icono'          => 'servidor',
        'imagen'         => 'images/home/infraestructura-red.jpg',
        'imagen_alt'     => 'Armario de red montado por VS Informática en la sede de un cliente',
        'meta_titulo'    => 'Mantenimiento informático para empresas en La Roda | VS Informática',
        'meta_descripcion' => 'Servidores, redes, seguridad y reparación con taller propio en La Roda. '
                            . 'Si tu servidor se para, estamos ahí.',
        'destacado'      => true,
        'hijos' => [

            'redes-y-servidores' => [
                'orden'          => 1,
                'nav'            => 'Infraestructura de Red',
                'titulo'         => 'Infraestructura de red',
                'titular'        => 'Infraestructura de red',
                'entradilla'     => 'Soluciones optimizadas',
                'sumario'        => 'Somos expertos en montajes de Redes, Servidores Windows Server '
                                  . 'e interconexión de sucursales.',
                'icono'          => 'red',
                'meta_titulo'    => 'Montaje de redes y servidores en Albacete | VS Informática',
                'meta_descripcion' => 'Redes estructuradas, Windows Server e interconexión de sucursales '
                                    . 'para empresas de La Roda y Albacete. Hardware, software y configuración profesional.',
            ],

            'ciberseguridad' => [
                'orden'          => 2,
                'nav'            => 'Seguridad',
                'titulo'         => 'Seguridad',
                'titular'        => 'Seguridad',
                'entradilla'     => 'Evite ataques y pérdida de datos',
                'sumario'        => '¿Cree que su empresa está segura? Le realizamos una auditoría de seguridad.',
                'icono'          => 'escudo',
                'meta_titulo'    => 'Seguridad informática para empresas en Albacete | Auditoría de seguridad',
                'meta_descripcion' => 'Auditoría de seguridad para empresas de La Roda y Albacete. '
                                    . 'Detectamos los riesgos internos y externos y le decimos qué hacer.',
            ],

            'reparacion' => [
                'orden'          => 3,
                'nav'            => 'Reparación',
                'titulo'         => 'Reparación',
                'titular'        => 'Reparación hardware',
                'entradilla'     => 'Sus equipos en perfecto estado',
                'sumario'        => 'Taller propio, con material en stock. Servidor, PC, portátiles, impresoras.',
                'icono'          => 'llave',
                'meta_titulo'    => 'Reparación de ordenadores en La Roda | Taller propio',
                'meta_descripcion' => 'Traes el equipo a la tienda y te lo devolvemos reparado. Taller propio '
                                    . 'con material en stock en La Roda: PC, portátiles, servidores e impresoras.',
            ],

        ],
    ],

    'cloud' => [
        'orden'          => 3,
        'nav'            => 'Cloud',
        'nav_subtitulo'  => 'Servicios en la nube',
        'titulo'         => 'Cloud',
        'titular'        => 'Servicios Cloud Integrales',
        'entradilla'     => 'Somos una empresa en crecimiento',
        'entradilla_2'   => 'que se centra en las tecnologías cloud más modernas.',
        'icono'          => 'nube',
        'imagen'         => 'images/home/cloud.png',
        'imagen_alt'     => 'Servicios en la nube de VS Informática: servidor, copias, correo y alojamiento',
        'meta_titulo'    => 'Servicios cloud para empresas en Albacete | VS Informática',
        'meta_descripcion' => 'Servidor cloud, copias de seguridad remotas, correo empresarial y hosting '
                            . 'para empresas de La Roda y Albacete.',
        'destacado'      => true,
        'hijos' => [

            'servidor-cloud' => [
                'orden'          => 1,
                'nav'            => 'Servidor Cloud',
                'titulo'         => 'Servidor Cloud',
                'titular'        => 'Servidor Cloud',
                'entradilla'     => 'Accede a tu empresa desde cualquier lugar',
                'sumario'        => 'Su servidor fuera de la empresa, en uno de los Data Center más potentes de España.',
                'icono'          => 'nube-servidor',
                'meta_titulo'    => 'Servidor cloud para empresas en Albacete | VS Informática',
                'meta_descripcion' => 'Tu servidor en la nube, en un Data Center español, con escalabilidad, '
                                    . 'ancho de banda de 100 a 300 MB y pago mensual.',
            ],

            'copias-de-seguridad' => [
                'orden'          => 2,
                'nav'            => 'Copias de seguridad cloud',
                'titulo'         => 'Copias Cloud',
                'titular'        => 'Copias de Seguridad Cloud',
                'entradilla'     => 'Sus datos mejor que nunca',
                'sumario'        => 'Mantenga todos sus datos críticos fuera de su empresa, de forma automática.',
                'icono'          => 'copia',
                'meta_titulo'    => 'Copias de seguridad para empresas en Albacete | VS Informática',
                'meta_descripcion' => 'Si mañana te entra un ransomware, recuperas los datos de ayer. Copia '
                                    . 'remota automática al Data Center de VS Informática.',
            ],

            'correo-electronico' => [
                'orden'          => 3,
                'nav'            => 'Correo Electrónico',
                'titulo'         => 'Correo Electrónico',
                'titular'        => 'Correo Electrónico',
                'entradilla'     => 'Buzones empresariales',
                'sumario'        => '¿Quieres tener cuentas de correo propias? Nosotros te lo adaptamos.',
                'icono'          => 'sobre',
                'meta_titulo'    => 'Correo electrónico empresarial en Albacete | VS Informática',
                'meta_descripcion' => 'Cuentas de correo con tu propio dominio, configuradas en IMAP o POP3 '
                                    . 'según lo que necesite tu empresa. Te asesoramos nosotros.',
            ],

            'alojamiento-y-dominio' => [
                'orden'          => 4,
                'nav'            => 'Alojamiento',
                'titulo'         => 'Hosting Profesional',
                'titular'        => 'Alojamiento y dominio',
                'entradilla'     => 'Alojamos su web y correos electrónicos',
                'sumario'        => '¿Dónde almaceno mi página web y mis correos electrónicos?',
                'icono'          => 'globo',
                'meta_titulo'    => 'Alojamiento web y registro de dominios | VS Informática',
                'meta_descripcion' => 'Planes de hosting profesional y registro de dominios. Te asesoramos '
                                    . 'sobre cuál se adapta mejor a tu empresa.',
            ],

        ],
    ],

    'otros' => [
        'orden'          => 4,
        'nav'            => 'Otros Servicios',
        'nav_subtitulo'  => 'Equipos, consumibles,...',
        'titulo'         => 'Otros Servicios',
        'titular'        => 'Otros Servicios',
        'entradilla'     => 'Queremos lo mejor para tí',
        'entradilla_2'   => 'y sabemos todas tus necesidades',
        'icono'          => 'caja',
        'imagen'         => 'images/servicios/equipos.jpg',
        'imagen_alt'     => 'Equipos de escritorio montados a medida por VS Informática',
        'meta_titulo'    => 'Equipos a medida y consumibles en La Roda | VS Informática',
        'meta_descripcion' => 'Montamos equipos de escritorio y portátiles con componentes de primeras '
                            . 'marcas, y tenemos consumibles de impresora en tienda.',
        'destacado'      => false,
        'hijos' => [

            'equipos-y-portatiles' => [
                'orden'          => 1,
                'nav'            => 'Equipos de escritorio y portátiles',
                'titulo'         => 'Equipos de escritorio y Portátiles',
                'titular'        => 'Equipos de Escritorio y Portátiles',
                'entradilla'     => 'Atención Personalizada · Servicio Postventa',
                'sumario'        => 'Montajes personalizados con componentes de primeras marcas. '
                                  . 'Partner de Intel desde 2008.',
                'icono'          => 'portatil',
                'meta_titulo'    => 'Ordenadores a medida en La Roda | Partner de Intel',
                'meta_descripcion' => 'Montamos equipos de altas prestaciones y bajo nivel sonoro con '
                                    . 'componentes de primeras marcas. Partner de Intel desde 2008.',
            ],

            'consumibles' => [
                'orden'          => 2,
                'nav'            => 'Consumibles',
                'titulo'         => 'Consumibles',
                'titular'        => 'Consumibles',
                'entradilla'     => 'Láser, tinta.',
                'sumario'        => 'Las referencias más demandadas, en tienda. Y si no la tenemos, te la localizamos.',
                'icono'          => 'impresora',
                'meta_titulo'    => 'Tóner y cartuchos de tinta en La Roda | VS Informática',
                'meta_descripcion' => 'Consumibles de impresora láser y de tinta en nuestra tienda de La Roda. '
                                    . 'Si no tenemos tu referencia, te la traemos en tiempo récord.',
            ],

        ],
    ],

];
