<?php

namespace App\Http\Controllers;

use App\Contenido\Servicios;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ServicioController extends Controller
{
    /** Índice completo del catálogo: las 4 secciones con todos sus hijos. */
    public function index(): View
    {
        return view('servicios.index', [
            'secciones' => Servicios::secciones(),
        ]);
    }

    /**
     * Una página de servicio.
     *
     * El cuerpo vive en su propia vista Blade (servicios/{slug}.blade.php) para
     * que cada página pueda tener la maqueta que pide su contenido — la de
     * a3ERP lleva galería y fichas de producto, la de alojamiento son
     * preguntas y respuestas. Los metadatos comunes se inyectan desde aquí.
     */
    public function show(string $slug): View
    {
        $servicio = Servicios::buscar($slug);

        abort_if($servicio === null, Response::HTTP_NOT_FOUND);

        return view("servicios.{$slug}", [
            'servicio' => $servicio,
            'migas'    => Servicios::migas($servicio),
        ]);
    }
}
