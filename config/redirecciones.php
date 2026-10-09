<?php

/*
|--------------------------------------------------------------------------
| Redirecciones 301 desde el Joomla antiguo
|--------------------------------------------------------------------------
|
| Cada URL .html del sitio original apunta a su equivalente nueva. Ninguna
| página vieja muere: todas tienen destino propio, ninguna se colapsa en un
| ancla. Estas redirecciones son las que conservan el posicionamiento.
|
| routes/web.php las recorre y registra un Route::permanentRedirect por cada
| una. Al desplegar en producción se pueden mover al .htaccess (resuelve
| antes de arrancar PHP), pero con este volumen la diferencia es irrelevante.
|
*/

return [

    // Software
    '/software-de-gestion-empresarial.html'                  => '/servicios/software-gestion-a3erp',

    // Hardware
    '/hardware.html'                                         => '/servicios/hardware',
    '/hardware/infraestructura-de-red.html'                  => '/servicios/redes-y-servidores',
    '/hardware/seguridad.html'                               => '/servicios/ciberseguridad',
    '/hardware/reparacion.html'                              => '/servicios/reparacion',

    // Cloud
    '/cloud.html'                                            => '/servicios/cloud',
    '/cloud/servidor-cloud.html'                             => '/servicios/servidor-cloud',
    '/cloud/copias-de-seguridad.html'                        => '/servicios/copias-de-seguridad',
    '/cloud/correo-electronico.html'                         => '/servicios/correo-electronico',
    '/cloud/alojamiento.html'                                => '/servicios/alojamiento-y-dominio',

    // Otros servicios
    '/otros-servicios.html'                                  => '/servicios/otros',
    '/otros-servicios/equipos-de-escritorio-y-portatiles.html' => '/servicios/equipos-y-portatiles',
    '/otros-servicios/consumibles.html'                      => '/servicios/consumibles',

    // Páginas sueltas
    '/empresa.html'                                          => '/empresa',
    '/contacto.html'                                         => '/contacto',
    '/mapa-del-sitio.html'                                   => '/mapa-del-sitio',

    /*
     | La tarjeta "Servidor Cloud" del índice de Cloud apuntaba a esta URL
     | interna de Joomla en vez de a la página amigable. Las rutas de Laravel
     | casan la ruta y no la query, así que se redirige el segmento entero.
     */
    '/component/content'                                     => '/servicios',

];
