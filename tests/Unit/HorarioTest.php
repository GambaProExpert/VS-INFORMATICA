<?php

/*
 | El horario de config/empresa.php.
 |
 | Aquí vivía la barra de estado, que se ha quitado de la web. Pero el dato
 | sigue alimentando el schema.org, el pie, la cabecera y la página de
 | contacto, así que la comprobación se queda: el plan de partida daba por
 | hecho un horario continuo hasta las 20:00 y el real son dos tramos.
 */

it('declara la jornada partida real', function () {
    $tramos = config('empresa.horario.tramos');

    expect($tramos)->toHaveCount(2)
        ->and($tramos[0])->toBe(['abre' => '09:30', 'cierra' => '13:30'])
        ->and($tramos[1])->toBe(['abre' => '16:30', 'cierra' => '19:00']);
});

it('escribe el horario legible acorde con los tramos', function () {
    // Si alguien cambia los tramos y se olvida del texto, la cabecera y el
    // schema.org dirían cosas distintas.
    $texto = config('empresa.horario.texto');

    foreach (config('empresa.horario.tramos') as $tramo) {
        expect($texto)->toContain($tramo['abre'])
            ->and($texto)->toContain($tramo['cierra']);
    }
});
