<?php

namespace App\Console\Commands;

use App\Models\Consulta;
use Illuminate\Console\Command;

/**
 * Borra las consultas del formulario con más de un año.
 *
 * El RGPD no permite guardar datos personales "por si acaso": hay que fijar un
 * plazo y cumplirlo. Aquí es un año, que es lo que declara la política de
 * privacidad. Si se cambia uno, hay que cambiar el otro.
 */
class PurgarConsultas extends Command
{
    protected $signature = 'consultas:purgar {--meses=12 : Antigüedad a partir de la cual se borran}';

    protected $description = 'Borra las consultas antiguas para cumplir el plazo de conservación del RGPD';

    public function handle(): int
    {
        $meses = (int) $this->option('meses');

        $borradas = Consulta::where('created_at', '<', now()->subMonths($meses))->delete();

        $this->info("{$borradas} consultas borradas (más de {$meses} meses).");

        return self::SUCCESS;
    }
}
