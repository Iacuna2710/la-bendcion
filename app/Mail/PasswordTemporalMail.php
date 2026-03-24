<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable PasswordTemporalMail
 *
 * Envía la contraseña temporal al usuario por correo electrónico.
 * Utiliza la clase Mailable de Laravel y envía el email a través del
 * servidor SMTP configurado en el .env.
 */
class PasswordTemporalMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * El usuario destinatario del correo.
     *
     * @var \App\Models\User
     */
    public User $usuario;

    /**
     * La contraseña temporal.
     *
     * @var string
     */
    public string $passwordTemporal;

    /**
     * Crea una nueva instancia del Mailable.
     *
     * @param  \App\Models\User  $usuario          Usuario que recibirá el correo
     * @param  string            $passwordTemporal  Contraseña temporal
     */
    public function __construct(User $usuario, string $passwordTemporal)
    {
        $this->usuario          = $usuario;
        $this->passwordTemporal = $passwordTemporal;
    }

    /**
     * Define el encabezado del correo.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu contraseña temporal — La Bendición',
        );
    }

    /**
     * Define el contenido del correo usando la vista Blade.
     * Las propiedades públicas se pasan automáticamente a la vista.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.password-temporal',
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
