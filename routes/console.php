<?php

use Illuminate\Support\Facades\Schedule;

/*
 | En hosting compartido esto necesita un cron real que llame cada minuto a
 |   php artisan schedule:run
 | Sin él, ninguna de las dos tareas se ejecuta nunca.
 */

// El sitemap solo cambia cuando cambia config/servicios.php, pero regenerarlo
// semanalmente es barato y evita que se quede obsoleto si a alguien se le olvida.
Schedule::command('sitemap:generar')->weeklyOn(1, '03:00');

// Plazo de conservación del RGPD: las consultas se borran al año.
Schedule::command('consultas:purgar')->dailyAt('03:30');
