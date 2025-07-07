<?php

namespace App\Mail;

use App\Models\Cotizacion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmacionCompraMail extends Mailable
{
    use Queueable, SerializesModels;

    // Hacemos la cotización accesible en la vista del email
    public $cotizacion;

    public function __construct(Cotizacion $cotizacion)
    {
        $this->cotizacion = $cotizacion;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmación de Compra de Asistencia de Viaje',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.confirmacion-compra',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
