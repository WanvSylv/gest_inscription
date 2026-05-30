<?php

namespace App\Mail;

use App\Models\Inscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DossierRecuEmail extends Mailable
{
    use Queueable, SerializesModels;

    public Inscription $inscription;

    public function __construct(Inscription $inscription)
    {
        $this->inscription = $inscription;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📋 Votre dossier a bien été reçu — HOREB ACADEMY',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.dossier-recu',
            with: ['inscription' => $this->inscription],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
