<?php

namespace App\Console\Commands;

use App\Contenido\Servicios;
use Illuminate\Console\Command;

/**
 * Genera public/sitemap.xml.
 *
 * Se construye a partir de config/servicios.php y de las rutas con nombre, no
 * rastreando la web: no hace falta que el servidor esté levantado y el
 * resultado es idéntico en cada ejecución. Por eso no usamos spatie/laravel-sitemap,
 * que rastrea y añade una dependencia para 20 URLs conocidas de antemano.
 */
class GenerarSitemap extends Command
{
    protected $signature = 'sitemap:generar';

    protected $description = 'Genera public/sitemap.xml a partir del catálogo de servicios y las rutas';

    public function handle(): int
    {
        $urls = [
            ['ruta' => route('home'),             'prioridad' => '1.0', 'frecuencia' => 'monthly'],
            ['ruta' => route('servicios.index'),  'prioridad' => '0.9', 'frecuencia' => 'monthly'],
            ['ruta' => route('empresa'),          'prioridad' => '0.7', 'frecuencia' => 'yearly'],
            ['ruta' => route('soporte'),          'prioridad' => '0.7', 'frecuencia' => 'yearly'],
            ['ruta' => route('contacto'),         'prioridad' => '0.8', 'frecuencia' => 'yearly'],
            ['ruta' => route('mapa'),             'prioridad' => '0.3', 'frecuencia' => 'yearly'],
        ];

        // Las secciones pesan más que sus hijas de cara al buscador.
        foreach (Servicios::todos() as $servicio) {
            $urls[] = [
                'ruta'       => $servicio['url'],
                'prioridad'  => $servicio['padre'] === null ? '0.9' : '0.8',
                'frecuencia' => 'monthly',
            ];
        }

        foreach (['legal.aviso', 'legal.privacidad', 'legal.cookies'] as $legal) {
            $urls[] = ['ruta' => route($legal), 'prioridad' => '0.2', 'frecuencia' => 'yearly'];
        }

        $hoy = now()->toDateString();

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"
             . "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($urls as $url) {
            $xml .= "    <url>\n"
                  . '        <loc>' . htmlspecialchars($url['ruta'], ENT_XML1) . "</loc>\n"
                  . "        <lastmod>{$hoy}</lastmod>\n"
                  . "        <changefreq>{$url['frecuencia']}</changefreq>\n"
                  . "        <priority>{$url['prioridad']}</priority>\n"
                  . "    </url>\n";
        }

        $xml .= "</urlset>\n";

        file_put_contents(public_path('sitemap.xml'), $xml);

        $this->info(count($urls) . ' URLs escritas en public/sitemap.xml');

        return self::SUCCESS;
    }
}
