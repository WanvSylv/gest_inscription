<?php

namespace App\Mail;

use App\Models\Inscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DossierValideEmail extends Mailable
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
            subject: '✅ Votre dossier a été validé — HOREB ACADEMY',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.dossier-valide',
            with: ['inscription' => $this->inscription],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
