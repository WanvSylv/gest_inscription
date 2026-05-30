<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;
    public string $email;

    public function __construct(string $email, string $code)
    {
        $this->email = $email;
        $this->code  = $code;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre code de vérification — HOREB ACADEMY',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
            with: [
                'code'  => $this->code,
                'email' => $this->email,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
