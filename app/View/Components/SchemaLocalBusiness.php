<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Datos estructurados LocalBusiness.
 *
 * Para "informático cerca de mí" esto pesa casi tanto como el contenido de la
 * página. Todo sale de config/empresa.php: el horario que declara aquí es
 * exactamente el mismo que muestra la barra de estado, así que no pueden
 * contradecirse.
 */
class SchemaLocalBusiness extends Component
{
    /** @return array<string, mixed> */
    public function datos(): array
    {
        $empresa   = config('empresa');
        $direccion = $empresa['direccion'];

        return [
            '@context'  => 'https://schema.org',
            '@type'     => 'LocalBusiness',
            '@id'       => url('/#local'),
            'name'      => $empresa['nombre_largo'],
            'legalName' => $empresa['razon_social'],
            'url'       => url('/'),
            'telephone' => $empresa['telefono']['e164'],
            'email'     => $empresa['email'],
            'vatID'     => $empresa['cif'],
            'foundingDate' => (string) $empresa['fundacion'],
            'image'     => asset('images/empresa/taller-mostrador.jpg'),
            'logo'      => asset('images/marca/logo.png'),
            'address'   => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => $direccion['calle'],
                'addressLocality' => $direccion['localidad'],
                'addressRegion'   => $direccion['provincia'],
                'postalCode'      => $direccion['cp'],
                'addressCountry'  => $direccion['pais'],
            ],
            'geo' => [
                '@type'     => 'GeoCoordinates',
                'latitude'  => $empresa['geo']['lat'],
                'longitude' => $empresa['geo']['lng'],
            ],
            // Un bloque por tramo: así el buscador entiende la jornada partida
            // en vez de dar por hecho que abrimos a mediodía.
            'openingHoursSpecification' => array_map(
                fn (array $tramo) => [
                    '@type'     => 'OpeningHoursSpecification',
                    'dayOfWeek' => $empresa['horario']['dias'],
                    'opens'     => $tramo['abre'],
                    'closes'    => $tramo['cierra'],
                ],
                $empresa['horario']['tramos'],
            ),
            'areaServed' => $empresa['zonas_servicio'],
            'priceRange' => '€€',
            'sameAs'     => array_values($empresa['redes']),
        ];
    }

    public function render(): View
    {
        return view('components.schema-local-business');
    }
}
