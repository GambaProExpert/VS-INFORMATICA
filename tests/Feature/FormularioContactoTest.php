<?php

use App\Livewire\FormularioContacto;
use App\Mail\NuevaConsulta;
use App\Models\Consulta;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;

/*
 | El formulario de contacto.
 |
 | Es la única pieza con estado de toda la web y la mejora funcional de más
 | peso de la renovación: antes no había forma de dejar recado fuera de
 | horario. Merece la pena cubrirlo bien.
 */

beforeEach(function () {
    Mail::fake();
    RateLimiter::clear('contacto:127.0.0.1');
});

function rellenar(array $cambios = []): Testable
{
    return Livewire::test(FormularioContacto::class)
        ->set(array_merge([
            'nombre'         => 'Marta Ruiz',
            'empresa'        => 'Talleres Ruiz',
            'telefono'       => '967123456',
            'email'          => 'marta@talleresruiz.es',
            'mensaje'        => 'Se nos ha parado el servidor esta mañana.',
            'consentimiento' => true,
        ], $cambios));
}

it('guarda la consulta y envía el aviso', function () {
    rellenar()->call('enviar')->assertSet('enviado', true);

    $consulta = Consulta::sole();

    expect($consulta->nombre)->toBe('Marta Ruiz')
        ->and($consulta->empresa)->toBe('Talleres Ruiz')
        ->and($consulta->email)->toBe('marta@talleresruiz.es')
        ->and($consulta->consentido_en)->not->toBeNull();

    Mail::assertSent(NuevaConsulta::class);
});

it('guarda en base de datos antes de mandar el correo', function () {
    /*
     | Si el SMTP falla, la consulta NO se puede perder: para una empresa
     | pequeña cada consulta es un cliente potencial. Se simula un fallo de
     | envío y se comprueba que la fila sigue ahí.
     */
    Mail::shouldReceive('to')->once()->andThrow(new RuntimeException('SMTP caído'));

    $reventó = false;

    try {
        rellenar()->call('enviar');
    } catch (Throwable $e) {
        // Comprobamos que ha reventado DE VERDAD: si no, este test pasaría
        // igual sin demostrar nada.
        $reventó = str_contains($e->getMessage(), 'SMTP caído');
    }

    expect($reventó)->toBeTrue('el envío de correo debería haber fallado')
        ->and(Consulta::count())->toBe(1, 'la consulta tiene que sobrevivir al fallo de SMTP');
});

it('deja la empresa vacía como nula', function () {
    rellenar(['empresa' => ''])->call('enviar');

    expect(Consulta::sole()->empresa)->toBeNull();
});

it('exige los campos obligatorios', function (string $campo) {
    rellenar([$campo => ''])
        ->call('enviar')
        ->assertHasErrors($campo);

    expect(Consulta::count())->toBe(0);
})->with(['nombre', 'telefono', 'email', 'mensaje']);

it('no acepta el envío sin consentimiento', function () {
    rellenar(['consentimiento' => false])
        ->call('enviar')
        ->assertHasErrors(['consentimiento' => 'accepted']);

    expect(Consulta::count())->toBe(0);
    Mail::assertNothingSent();
});

it('rechaza un email mal formado', function () {
    rellenar(['email' => 'esto-no-es-un-email'])
        ->call('enviar')
        ->assertHasErrors(['email' => 'email']);
});

it('rechaza el envío si el honeypot viene relleno', function () {
    // Un bot rellena todos los campos que encuentra, incluido el que está
    // oculto por CSS. Una persona nunca lo ve.
    rellenar(['apellidos' => 'Relleno por un bot'])
        ->call('enviar')
        ->assertHasErrors(['apellidos' => 'prohibited']);

    expect(Consulta::count())->toBe(0);
    Mail::assertNothingSent();
});

it('corta al sexto envío en el mismo minuto', function () {
    foreach (range(1, 5) as $i) {
        rellenar()->call('enviar');
    }

    expect(Consulta::count())->toBe(5);

    rellenar()->call('enviar')->assertHasErrors('mensaje');

    expect(Consulta::count())->toBe(5);
});

it('no acepta un mensaje interminable', function () {
    rellenar(['mensaje' => str_repeat('a', 2001)])
        ->call('enviar')
        ->assertHasErrors(['mensaje' => 'max']);
});

it('guarda la fecha y la IP del consentimiento', function () {
    // El RGPD exige poder demostrar cuándo se dio el consentimiento.
    rellenar()->call('enviar');

    $consulta = Consulta::sole();

    expect($consulta->consentido_en)->not->toBeNull()
        ->and($consulta->ip)->not->toBeNull();
});
