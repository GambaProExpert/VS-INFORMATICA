<?php

/*
|--------------------------------------------------------------------------
| Mensajes de validación en español
|--------------------------------------------------------------------------
|
| Laravel no trae español de serie. Aquí están las reglas que usa esta web
| más las más habituales, por si se añaden campos en el futuro.
|
| Los mensajes específicos del formulario de contacto (los que hablan de tú y
| explican POR QUÉ hace falta el dato) están en el propio componente Livewire:
| App\Livewire\FormularioContacto::messages(). Estos son el respaldo.
|
*/

return [

    'accepted'   => 'Debes aceptar :attribute.',
    'after'      => ':Attribute debe ser una fecha posterior a :date.',
    'alpha'      => ':Attribute sólo puede contener letras.',
    'alpha_num'  => ':Attribute sólo puede contener letras y números.',
    'before'     => ':Attribute debe ser una fecha anterior a :date.',
    'boolean'    => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed'  => 'La confirmación de :attribute no coincide.',
    'date'       => ':Attribute no es una fecha válida.',
    'different'  => ':Attribute y :other deben ser diferentes.',
    'digits'     => ':Attribute debe tener :digits dígitos.',
    'email'      => ':Attribute no es una dirección de correo válida.',
    'file'       => ':Attribute debe ser un fichero.',
    'filled'     => 'El campo :attribute no puede estar vacío.',
    'image'      => ':Attribute debe ser una imagen.',
    'in'         => ':Attribute no es un valor válido.',
    'integer'    => ':Attribute debe ser un número entero.',
    'max'        => [
        'array'   => ':Attribute no puede tener más de :max elementos.',
        'file'    => ':Attribute no puede ocupar más de :max kilobytes.',
        'numeric' => ':Attribute no puede ser mayor que :max.',
        'string'  => ':Attribute no puede tener más de :max caracteres.',
    ],
    'min' => [
        'array'   => ':Attribute debe tener al menos :min elementos.',
        'file'    => ':Attribute debe ocupar al menos :min kilobytes.',
        'numeric' => ':Attribute debe ser al menos :min.',
        'string'  => ':Attribute debe tener al menos :min caracteres.',
    ],
    'numeric'    => ':Attribute debe ser un número.',
    'prohibited' => 'El campo :attribute no está permitido.',
    'regex'      => 'El formato de :attribute no es válido.',
    'required'   => 'El campo :attribute es obligatorio.',
    'same'       => ':Attribute y :other deben coincidir.',
    'size' => [
        'array'   => ':Attribute debe contener :size elementos.',
        'file'    => ':Attribute debe ocupar :size kilobytes.',
        'numeric' => ':Attribute debe ser :size.',
        'string'  => ':Attribute debe tener :size caracteres.',
    ],
    'string' => ':Attribute debe ser texto.',
    'unique' => ':Attribute ya está en uso.',
    'url'    => 'El formato de :attribute no es válido.',

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    'attributes' => [
        'nombre'         => 'nombre',
        'empresa'        => 'empresa',
        'telefono'       => 'teléfono',
        'email'          => 'email',
        'mensaje'        => 'mensaje',
        'consentimiento' => 'la política de privacidad',
        'apellidos'      => 'apellidos',
    ],

];
