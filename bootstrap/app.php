<?php

use App\Http\Middleware\NoIndexar;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        /*
         * Detrás de un túnel (Dev Tunnels de Visual Studio, Cloudflare) o de un
         * balanceador, la petición le llega a PHP como HTTP plano desde
         * 127.0.0.1, y lo que el visitante tiene en la barra es https://. Sin
         * esto pasan tres cosas, y las tres son problemas:
         *
         *   1. Laravel cree que la página es http:// y genera los enlaces de
         *      los assets en http:// dentro de una página https://. El
         *      navegador los bloquea por contenido mixto y la web se ve sin
         *      estilos, sin tipografías y sin rack.
         *   2. request()->ip() devuelve 127.0.0.1 para todo el mundo, así que
         *      el límite de cinco envíos del formulario de contacto pasa a ser
         *      compartido entre todos los visitantes en vez de por persona.
         *   3. La IP que se guarda con cada consulta —dato que el RGPD nos hace
         *      justificar— sería siempre la misma y no valdría para nada.
         *
         * `at: '*'` confía en cualquier proxy porque la IP del túnel cambia en
         * cada arranque y no hay nada fijo que enumerar. Es lo que Laravel
         * recomienda para balanceadores de IP dinámica. Tiene un coste que
         * conviene saber: quien llegue directo puede falsear su X-Forwarded-For
         * y saltarse el límite del formulario. En un hosting definitivo, donde
         * sí se conoce la IP del proxy, hay que poner esa IP aquí en su lugar.
         */
        $middleware->trustProxies(at: '*');

        $middleware->web(append: [
            NoIndexar::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
