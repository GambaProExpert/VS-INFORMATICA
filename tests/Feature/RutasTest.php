<?php

use App\Contenido\Servicios;

/*
 | Que las 22 páginas respondan y tengan un solo <h1>.
 |
 | Parece poca cosa, pero es la red que avisa cuando alguien añade un servicio
 | a config/servicios.php y se olvida de crear su vista: la web seguiría
 | compilando y el fallo solo saldría al visitar esa URL.
 */

dataset('paginas fijas', [
    'inicio'          => '/',
    'servicios'       => '/servicios',
    'empresa'         => '/empresa',
    'soporte'         => '/soporte',
    'mapa del sitio'  => '/mapa-del-sitio',
    'contacto'        => '/contacto',
    'aviso legal'     => '/aviso-legal',
    'privacidad'      => '/privacidad',
    'cookies'         => '/cookies',
]);

it('responde con 200', function (string $url) {
    $this->get($url)->assertOk();
})->with('paginas fijas');

it('sirve todas las páginas de servicios del catálogo', function () {
    $servicios = Servicios::todos();

    expect($servicios)->toHaveCount(13);

    foreach ($servicios as $slug => $servicio) {
        $this->get("/servicios/{$slug}")
            ->assertOk()
            ->assertSee($servicio['titular'], escape: false);
    }
});

it('devuelve 404 en un servicio que no existe', function () {
    $this->get('/servicios/no-existe')->assertNotFound();
});

it('pone exactamente un h1 en cada página', function (string $url) {
    $html = $this->get($url)->getContent();

    expect(substr_count($html, '<h1'))->toBe(1, "«{$url}» debería tener un solo <h1>");
})->with('paginas fijas');

it('pone exactamente un h1 en cada página de servicio', function () {
    foreach (Servicios::todos()->keys() as $slug) {
        $html = $this->get("/servicios/{$slug}")->getContent();

        expect(substr_count($html, '<h1'))->toBe(1, "«{$slug}» debería tener un solo <h1>");
    }
});

it('publica los datos estructurados de LocalBusiness con el horario partido', function () {
    $html = $this->get('/')->getContent();

    preg_match('~<script type="application/ld\+json">(.*?)</script>~s', $html, $m);

    $datos = json_decode($m[1] ?? '{}', true);

    expect($datos['@type'])->toBe('LocalBusiness')
        ->and($datos['telephone'])->toBe('+34967445153')
        ->and($datos['address']['postalCode'])->toBe('02630')
        // Dos tramos, no uno: es jornada partida.
        ->and($datos['openingHoursSpecification'])->toHaveCount(2)
        ->and($datos['openingHoursSpecification'][0]['closes'])->toBe('13:30')
        ->and($datos['openingHoursSpecification'][1]['opens'])->toBe('16:30');
});

it('enseña el email como mailto y no como imagen', function () {
    // En el sitio antiguo el correo era un PNG, invisible para buscadores
    // y para lectores de pantalla.
    $this->get('/')->assertSee('mailto:lopd@vsinformatica.es', escape: false);
});

it('enseña el teléfono como enlace tel:', function () {
    $this->get('/')->assertSee('tel:+34967445153', escape: false);
});
