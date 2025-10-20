<?php

namespace App\Mail;

use App\Models\Cotizacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacionCompraMail extends Mailable
{
    use Queueable, SerializesModels;

    public Cotizacion $cotizacion;

    public function __construct(Cotizacion $cotizacion)
    {
        // ✅ garantizamos que 'pasajeros' venga como Collection (no null)
        $this->cotizacion = $cotizacion->loadMissing('pasajeros');
    }

    public function build()
    {
        return $this->subject('Confirmación de compra #'.$this->cotizacion->id)
            ->view('emails.confirmacion-compra')
            ->with([
                'cotizacion' => $this->cotizacion,
                // por si quieres usar una variable directa en la vista
                'pasajeros'  => $this->cotizacion->pasajeros,
            ]);
    }
}
