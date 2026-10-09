<?php

namespace App\Mail;

use App\Models\Consulta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Aviso interno de que ha entrado una consulta por la web.
 *
 * El Reply-To apunta a quien escribe, para que responder desde el correo
 * funcione sin copiar y pegar la dirección.
 */
class NuevaConsulta extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Consulta $consulta) {}

    public function envelope(): Envelope
    {
        $empresa = $this->consulta->empresa ? " ({$this->consulta->empresa})" : '';

        return new Envelope(
            subject: "Consulta web de {$this->consulta->nombre}{$empresa}",
            replyTo: [new Address($this->consulta->email, $this->consulta->nombre)],
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'mail.nueva-consulta');
    }
}
