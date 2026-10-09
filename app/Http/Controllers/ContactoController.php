<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ContactoController extends Controller
{
    public function __invoke(): View
    {
        return view('paginas.contacto');
    }
}
