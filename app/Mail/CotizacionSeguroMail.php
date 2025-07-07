<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CotizacionSeguroMail extends Mailable
{
    use Queueable, SerializesModels;

    // 1. Hacemos que los datos estén disponibles públicamente en la clase
    public array $datos_seguro;

    /**
     * Create a new message instance.
     *
     * @param array $datos_seguro Los datos de la cotización del formulario.
     */
    public function __construct(array $datos_seguro)
    {
        // 2. Recibimos los datos y los asignamos a nuestra variable pública
        $this->datos_seguro = $datos_seguro;
    }

    /**
     * Get the message envelope.
     * Define el "sobre": remitente, destinatario, asunto.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Aquí está tu cotización de seguro',
        );
    }

    /**
     * Get the message content definition.
     * Define el contenido: la vista que se usará como cuerpo del email.
     */
    public function content(): Content
    {
        return new Content(
            // 3. Le decimos a Laravel que use esta vista para el email
            view: 'emails.cotizacion',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
