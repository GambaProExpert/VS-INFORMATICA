<?php

namespace App\Contenido;

use Illuminate\Support\Collection;

/**
 * Repositorio de solo lectura sobre config/servicios.php.
 *
 * Aplana el árbol de secciones e hijos en una colección indexada por slug,
 * para que el menú, las tarjetas, las migas y el sitemap consulten siempre
 * lo mismo. Es la única clase que conoce la forma del array de configuración:
 * si algún día el contenido se muda a Eloquent, se reescribe esta clase y
 * las vistas no cambian.
 */
class Servicios
{
    /** Caché en memoria para no rehacer el aplanado en cada llamada. */
    private static ?Collection $plano = null;

    /**
     * Las 4 secciones de primer nivel, ordenadas, cada una con sus hijos ya
     * resueltos. Es lo que consume el menú desplegable y el mapa del sitio.
     */
    public static function secciones(): Collection
    {
        return collect(config('servicios'))
            ->map(fn (array $datos, string $slug) => self::componer($slug, $datos, padre: null))
            ->sortBy('orden')
            ->values();
    }

    /** Todos los servicios (secciones + hijos) en una sola colección plana. */
    public static function todos(): Collection
    {
        if (self::$plano !== null) {
            return self::$plano;
        }

        $plano = collect();

        foreach (config('servicios') as $slug => $datos) {
            $seccion = self::componer($slug, $datos, padre: null);
            $plano->put($slug, $seccion);

            foreach ($seccion['hijos'] as $hijo) {
                $plano->put($hijo['slug'], $hijo);
            }
        }

        return self::$plano = $plano;
    }

    /** Un servicio por su slug, o null si no existe. */
    public static function buscar(string $slug): ?array
    {
        return self::todos()->get($slug);
    }

    /** Las secciones marcadas como destacadas, para las tarjetas de la home. */
    public static function destacados(): Collection
    {
        return self::secciones()->where('destacado', true);
    }

    /**
     * Migas de pan de un servicio: Inicio › Servicios › [sección] › [hijo].
     * Devuelve pares ['titulo' => ..., 'url' => ...].
     */
    public static function migas(array $servicio): array
    {
        $migas = [
            ['titulo' => 'Inicio',    'url' => route('home')],
            ['titulo' => 'Servicios', 'url' => route('servicios.index')],
        ];

        if ($servicio['padre'] !== null && $padre = self::buscar($servicio['padre'])) {
            $migas[] = ['titulo' => $padre['titulo'], 'url' => $padre['url']];
        }

        $migas[] = ['titulo' => $servicio['titulo'], 'url' => null];

        return $migas;
    }

    /**
     * Normaliza una entrada del config: rellena las claves opcionales, calcula
     * la URL y resuelve recursivamente los hijos.
     */
    private static function componer(string $slug, array $datos, ?string $padre): array
    {
        $hijos = collect($datos['hijos'] ?? [])
            ->map(fn (array $h, string $s) => self::componer($s, $h, padre: $slug))
            ->sortBy('orden')
            ->values()
            ->all();

        return [
            'slug'             => $slug,
            'padre'            => $padre,
            'orden'            => $datos['orden'] ?? 99,
            'url'              => route('servicios.show', $slug),
            'nav'              => $datos['nav'] ?? $datos['titulo'],
            'nav_subtitulo'    => $datos['nav_subtitulo'] ?? null,
            'titulo'           => $datos['titulo'],
            'titular'          => $datos['titular'] ?? $datos['titulo'],
            'entradilla'       => $datos['entradilla'] ?? '',
            'entradilla_2'     => $datos['entradilla_2'] ?? null,
            'sumario'          => $datos['sumario'] ?? $datos['entradilla'] ?? '',
            'icono'            => $datos['icono'] ?? 'caja',
            'imagen'           => $datos['imagen'] ?? null,
            'imagen_alt'       => $datos['imagen_alt'] ?? '',
            'meta_titulo'      => $datos['meta_titulo'] ?? $datos['titulo'],
            'meta_descripcion' => $datos['meta_descripcion'] ?? '',
            'destacado'        => $datos['destacado'] ?? false,
            'hijos'            => $hijos,
        ];
    }
}
