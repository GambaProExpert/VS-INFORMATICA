<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/*
 | Cabecera noindex mientras la web se enseña por un túnel.
 |
 | La URL de un túnel es pública: cualquiera que la tenga entra, y los
 | buscadores llegan a ellas por los sitios más tontos —una barra de
 | direcciones que sincroniza, un enlace pegado en un chat—. Si Google indexa
 | la demostración, VS Informática acaba con una copia de su web compitiendo
 | contra ella misma por sus propias búsquedas. Eso hace daño de verdad.
 |
 | Es una cabecera y no un `Disallow: /` en robots.txt a propósito, aunque lo
 | segundo parezca más contundente: `Disallow` prohíbe *rastrear*, no
 | *indexar*. Google puede listar igualmente una URL que tiene prohibido leer
 | si la encuentra enlazada —sale en los resultados sin descripción—, y como no
 | puede entrar, tampoco llega a ver que le pedías que no la indexara. Con la
 | cabecera entra, lee el noindex y la descarta.
 |
 | Solo actúa con DEMO_PUBLICA=true, que pone scripts/demo.ps1. En producción
 | esta clase no hace nada.
 |
 | Ojo: los ficheros de public/ (imágenes, robots.txt, sitemap.xml) los sirve
 | el servidor sin pasar por Laravel, así que no llevan la cabecera. Para una
 | demostración de unas horas es asumible.
 */
class NoIndexar
{
    public function handle(Request $request, Closure $next): Response
    {
        $respuesta = $next($request);

        if (config('app.demo_publica')) {
            $respuesta->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive');
        }

        return $respuesta;
    }
}
