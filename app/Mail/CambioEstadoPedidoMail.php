<?php

namespace App\Mail;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable CambioEstadoPedidoMail
 *
 * Notifica al cliente por correo cuando el estado de su pedido cambia
 * desde el panel administrativo (RF-16).
 * Usa SMTP configurado en .env (Mailtrap en desarrollo).
 */
class CambioEstadoPedidoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * El pedido cuyo estado cambió.
     * Debe venir cargado con la relación 'estadoPedido'.
     *
     * @var \App\Models\Pedido
     */
    public Pedido $pedido;

    /**
     * Crea una nueva instancia del Mailable.
     *
     * @param  \App\Models\Pedido  $pedido  Pedido con estadoPedido cargado
     */
    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * Define el encabezado del correo (asunto).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Actualización de tu pedido {$this->pedido->num_pedido} — La Bendición",
        );
    }

    /**
     * Define el contenido del correo usando la vista Blade.
     * La propiedad pública $pedido se pasa automáticamente a la vista.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.cambio-estado-pedido',
        );
    }

    /**
     * Sin archivos adjuntos.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
