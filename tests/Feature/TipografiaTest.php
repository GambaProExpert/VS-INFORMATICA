<?php

/*
 | La web usa dos familias y solo dos: Bricolage Grotesque para titulares y
 | Public Sans para todo lo demás.
 |
 | Hubo una tercera, IBM Plex Mono, para las versalitas pequeñas. Se leía
 | estrecha y técnica y se retiró. Este test evita que vuelva a colarse en un
 | copiar y pegar, porque la clase `font-mono` seguiría "funcionando"
 | silenciosamente cayendo en la monoespaciada del sistema.
 */

it('no deja ninguna clase font-mono en las vistas', function () {
    $restos = [];

    $vistas = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(resource_path('views'))
    );

    foreach ($vistas as $fichero) {
        if ($fichero->isDir() || ! str_ends_with($fichero->getFilename(), '.blade.php')) {
            continue;
        }

        if (str_contains(file_get_contents($fichero->getPathname()), 'font-mono')) {
            $restos[] = $fichero->getFilename();
        }
    }

    expect($restos)->toBeEmpty();
});

it('no declara el token ni la familia monoespaciada en el CSS', function () {
    $css = file_get_contents(resource_path('css/app.css'));

    expect($css)->not->toContain('--font-mono:')
        ->and($css)->not->toContain("font-family: 'IBM Plex Mono'");
});

it('solo autoaloja las dos familias que se usan', function () {
    $fuentes = glob(resource_path('fuentes/*.woff2'));

    expect($fuentes)->toHaveCount(4);

    foreach ($fuentes as $fuente) {
        expect(basename($fuente))->toMatch('/^(public-sans|bricolage-grotesque)/');
    }
});

it('rotula con la utilidad etiqueta, que es donde vive el espaciado', function () {
    // En una proporcional las versalitas necesitan más aire que en una mono:
    // el letter-spacing de `etiqueta` es lo que evita que "GESTIÓN EMPRESARIAL"
    // quede apelmazado bajo el título del menú.
    expect(file_get_contents(resource_path('css/app.css')))
        ->toContain('@utility etiqueta')
        ->toContain('letter-spacing: 0.14em');

    $this->get('/')->assertOk()->assertSee('etiqueta', escape: false);
});
