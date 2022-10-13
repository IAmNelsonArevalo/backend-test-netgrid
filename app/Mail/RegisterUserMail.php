<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegisterUserMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * This variable show the username.
     * @var string | null
     */
    public ?string $name = null;

    /**
     * This variable show the email.
     * @var string | null
     */
    public ?string $email = null;

    /**
     * This variable show the active url.
     * @var string | null
     */
    public ?string $url_active = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name, string $email, int $id)
    {
        $this->name = $name;
        $this->email = $email;
        $hashedId = base64_encode($id);
        $this->url_active = env("APP_URL") . "/api/auth/active_user/$hashedId";
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Activacion de cuenta',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.register',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
