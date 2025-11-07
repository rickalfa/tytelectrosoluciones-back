<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\Contacto;

class RespuestaCliente extends Mailable
{
    use Queueable, SerializesModels;


    // 2. Creamos una propiedad pública para guardar el contacto
    public Contacto $contacto;


    /**
     * Create a new message instance.
     */
    public function __construct(Contacto $contacto)
    {
       // 4. Lo asignamos a la propiedad pública
        $this->contacto = $contacto;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmación de contacto - TyT ElectroSoluciones',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.respuesta-cliente',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
