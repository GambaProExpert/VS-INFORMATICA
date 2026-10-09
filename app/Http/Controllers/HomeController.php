<?php

namespace App\Http\Controllers;

use App\Contenido\Servicios;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'servicios' => Servicios::secciones(),
        ]);
    }
}
