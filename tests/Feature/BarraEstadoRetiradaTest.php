<?php

/*
 | La barra de estado se retiró en la fase 2.
 |
 | Anunciaba "FIN DE SEMANA · DÉJANOS TU INCIDENCIA Y TE LLAMAMOS EL LUNES A
 | PRIMERA HORA" y era lo primero que leía quien entraba un sábado. Este test
 | evita que vuelva por la puerta de atrás en un copiar y pegar.
 */

it('no deja ninguna invocación del componente en las vistas', function () {
    $restos = [];

    $vistas = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(resource_path('views'))
    );

    foreach ($vistas as $fichero) {
        if ($fichero->isDir() || ! str_ends_with($fichero->getFilename(), '.blade.php')) {
            continue;
        }

        if (str_contains(file_get_contents($fichero->getPathname()), 'x-barra-estado')) {
            $restos[] = $fichero->getFilename();
        }
    }

    expect($restos)->toBeEmpty();
});

it('ya no muestra el aviso de fin de semana en ninguna página', function (string $url) {
    $this->get($url)
        ->assertOk()
        ->assertDontSee('Fin de semana', escape: false)
        ->assertDontSee('Déjanos tu incidencia', escape: false);
})->with(['/', '/contacto', '/servicios', '/empresa']);

it('sigue publicando el horario, que es el dato útil', function () {
    $this->get('/')->assertSee(config('empresa.horario.texto'), escape: false);
});
