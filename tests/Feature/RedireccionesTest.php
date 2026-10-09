<?php

/*
 | Las 301 desde el Joomla antiguo.
 |
 | Es lo que conserva el posicionamiento de 25 años. Si una se rompe, la página
 | vieja pasa a devolver 404 y Google acaba desindexándola, así que conviene
 | que un test se dé cuenta antes que el buscador.
 */

it('redirige todas las URLs antiguas con 301', function () {
    $redirecciones = config('redirecciones');

    expect($redirecciones)->not->toBeEmpty();

    foreach ($redirecciones as $viejo => $nuevo) {
        $respuesta = $this->get($viejo);

        expect($respuesta->getStatusCode())
            ->toBe(301, "«{$viejo}» debería redirigir con 301 permanente");

        $respuesta->assertRedirect($nuevo);
    }
});

it('lleva cada redirección a una página que existe de verdad', function () {
    foreach (config('redirecciones') as $viejo => $nuevo) {
        $this->get($nuevo)->assertOk("«{$viejo}» apunta a «{$nuevo}», que no responde");
    }
});

it('cubre las 17 páginas del sitio original', function () {
    // 13 de servicios + empresa + contacto + mapa + la URL interna de Joomla.
    expect(config('redirecciones'))->toHaveCount(17);
});
