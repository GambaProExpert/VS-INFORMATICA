<?php

namespace App\Livewire;

use App\Mail\NuevaConsulta;
use App\Models\Consulta;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;

/**
 * Formulario de contacto.
 *
 * El sitio original no tenía ninguno: el único canal era llamar por teléfono en
 * horario de oficina. Esta es la mejora funcional de más peso de la renovación,
 * así que conviene que no se pierda ni una consulta.
 *
 * Cinco campos y ni uno más. Cada campo extra baja la conversión, y para
 * devolver una llamada basta con saber quién eres, cómo llamarte y qué te pasa.
 */
class FormularioContacto extends Component
{
    #[Validate('required|string|max:100', as: 'nombre')]
    public string $nombre = '';

    #[Validate('nullable|string|max:120', as: 'empresa')]
    public string $empresa = '';

    #[Validate('required|string|max:20', as: 'teléfono')]
    public string $telefono = '';

    #[Validate('required|email:rfc|max:150', as: 'email')]
    public string $email = '';

    #[Validate('required|string|max:2000', as: 'mensaje')]
    public string $mensaje = '';

    #[Validate('accepted')]
    public bool $consentimiento = false;

    /**
     * Honeypot. Se pinta oculto por CSS (nunca type="hidden", que los bots se
     * saltan) y la regla 'prohibited' hace fallar el envío si llega relleno.
     */
    #[Validate('prohibited')]
    public string $apellidos = '';

    public bool $enviado = false;

    public function messages(): array
    {
        return [
            'nombre.required'         => 'Dinos cómo te llamas.',
            'telefono.required'       => 'Necesitamos un teléfono para poder llamarte.',
            'email.required'          => 'Necesitamos un email para responderte.',
            'email.email'             => 'Ese email no parece correcto, revísalo.',
            'mensaje.required'        => 'Cuéntanos brevemente qué necesitas.',
            'mensaje.max'             => 'El mensaje es demasiado largo. Resúmelo y lo hablamos por teléfono.',
            'consentimiento.accepted' => 'Necesitamos tu consentimiento para poder contactarte.',
            'apellidos.prohibited'    => 'No hemos podido procesar el formulario. Llámanos por teléfono.',
        ];
    }

    public function enviar(): void
    {
        $this->limitar();

        $datos = $this->validate();

        /*
         | Primero a la base de datos y después el correo, en este orden y a
         | propósito: si el SMTP falla, la consulta ya está guardada y no se
         | pierde. Al revés, un fallo de correo se llevaría el aviso por delante.
         */
        $consulta = Consulta::create([
            'nombre'        => $datos['nombre'],
            'empresa'       => $datos['empresa'] ?: null,
            'telefono'      => $datos['telefono'],
            'email'         => $datos['email'],
            'mensaje'       => $datos['mensaje'],
            'consentido_en' => now(),
            'ip'            => request()->ip(),
        ]);

        Mail::to(config('mail.destinatario_avisos'))->send(new NuevaConsulta($consulta));

        $this->enviado = true;
    }

    /** Cinco envíos por minuto y por IP. */
    private function limitar(): void
    {
        $clave = 'contacto:' . request()->ip();

        if (RateLimiter::tooManyAttempts($clave, maxAttempts: 5)) {
            throw ValidationException::withMessages([
                'mensaje' => 'Has enviado demasiadas consultas seguidas. Espera un minuto o llámanos por teléfono.',
            ]);
        }

        RateLimiter::hit($clave, decaySeconds: 60);
    }

    public function render()
    {
        return view('livewire.formulario-contacto');
    }
}
