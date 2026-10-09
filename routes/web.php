<?php

use App\Http\Controllers\ContactoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicioController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::prefix('servicios')->name('servicios.')->group(function () {
    Route::get('/', [ServicioController::class, 'index'])->name('index');
    Route::get('/{slug}', [ServicioController::class, 'show'])->name('show');
});

Route::view('/empresa', 'paginas.empresa')->name('empresa');
Route::view('/soporte', 'paginas.soporte')->name('soporte');
Route::view('/mapa-del-sitio', 'paginas.mapa')->name('mapa');

// El envío lo gestiona el componente Livewire, con su propio límite de
// peticiones; aquí solo se sirve la página.
Route::get('/contacto', ContactoController::class)->name('contacto');

Route::view('/aviso-legal', 'legal.aviso')->name('legal.aviso');
Route::view('/privacidad', 'legal.privacidad')->name('legal.privacidad');
Route::view('/cookies', 'legal.cookies')->name('legal.cookies');

/*
 | Redirecciones 301 desde el Joomla antiguo. Se registran al final para que
 | ninguna pueda ensombrecer a una ruta real.
 */
foreach (config('redirecciones') as $viejo => $nuevo) {
    Route::permanentRedirect($viejo, $nuevo);
}
