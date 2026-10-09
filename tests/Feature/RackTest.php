<?php

/*
 | La sección del rack de la home.
 |
 | Lo que se prueba aquí no es el 3D —eso es WebGL y no se puede montar en un
 | test de PHP—, sino lo que de verdad importa: que el contenido esté en el
 | HTML sin depender de que arranque una escena de Three.js, y que las seis
 | unidades apunten a páginas que existen.
 */

it('sirve las seis unidades en el HTML, sin depender del 3D', function () {
    $html = $this->get('/')->assertOk()->getContent();

    // Se cuenta el elemento, no la cadena suelta: "data-rack-paso" aparece
    // también dentro de las variantes de Tailwind del contenedor.
    expect(substr_count($html, '<li data-rack-paso'))->toBe(6);

    // Arranca en modo texto: el 3D solo lo activa el JavaScript si puede.
    expect($html)->toContain('data-rack-estado="texto"');
});

it('enseña el texto de cada unidad aunque no haya JavaScript', function () {
    $respuesta = $this->get('/');

    foreach ([
        'Cableado ordenado y etiquetado',
        'La red que conecta todos los puestos',
        'Lo que separa tu empresa de Internet',
        'Los datos, centralizados y con permisos',
        'Si mañana entra un ransomware, recuperas lo de ayer',
        'Un corte de luz deja de ser un problema',
    ] as $titulo) {
        $respuesta->assertSee($titulo, escape: false);
    }
});

it('enlaza cada unidad con un servicio que existe', function () {
    $rutas = [
        'redes-y-servidores',
        'ciberseguridad',
        'hardware',
        'copias-de-seguridad',
        'reparacion',
    ];

    $html = $this->get('/')->getContent();

    foreach ($rutas as $slug) {
        expect($html)->toContain(route('servicios.show', $slug));

        $this->get("/servicios/{$slug}")->assertOk();
    }
});

it('no carga Three.js desde el HTML: el 3D entra por import dinámico', function () {
    // Si alguien mete un <script src=".../three..."> en el layout, el peso de
    // la escena volvería a la carga inicial y este test lo pillaría.
    $html = $this->get('/')->getContent();

    expect($html)->not->toContain('three.module')
        ->and($html)->not->toContain('/three.js');
});
