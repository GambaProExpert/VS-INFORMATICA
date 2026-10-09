<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Una consulta recibida por el formulario de contacto.
 *
 * Contiene datos personales, así que tiene fecha de caducidad: el comando
 * App\Console\Commands\PurgarConsultas borra las de más de un año para cumplir
 * el principio de limitación del plazo de conservación del RGPD.
 */
class Consulta extends Model
{
    protected $fillable = [
        'nombre',
        'empresa',
        'telefono',
        'email',
        'mensaje',
        'consentido_en',
        'ip',
    ];

    protected function casts(): array
    {
        return [
            'consentido_en' => 'datetime',
            'atendida_en'   => 'datetime',
        ];
    }

    public function atendida(): bool
    {
        return $this->atendida_en !== null;
    }
}
