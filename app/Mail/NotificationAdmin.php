<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Contacto; // <-- 1. Importamos tu Modelo

// Asegúrate que el nombre de la clase sea NotificationAdmin (con 't')
class NotificationAdmin extends Mailable
{
    use Queueable, SerializesModels;

    // 2. Creamos la propiedad pública
    public Contacto $contacto;

    /**
     * Create a new message instance.
     *
     * 3. Recibimos el Contacto
     */
    public function __construct(Contacto $contacto)
    {
        // 4. Lo asignamos a la propiedad pública
        $this->contacto = $contacto;
    }

    /**
     * Get the message envelope.
     * Define el ASUNTO
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Nuevo Mensaje de Contacto en la Web!', // <-- 5. Asunto
        );
    }

    /**
     * Get the message content definition.
     * Define la PLANTILLA
     */
    public function content(): Content
    {
        // 6. Asegúrate que la plantilla se llame 'notificacion-admin'
        return new Content(
            view: 'emails.notificacion-admin', 
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