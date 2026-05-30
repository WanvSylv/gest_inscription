<?php

namespace App\Mail;

use App\Models\Inscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NouveauDossierAdminEmail extends Mailable
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
            subject: '🔔 Nouveau dossier reçu — ' . $this->inscription->etudiant->full_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.nouveau-dossier-admin',
            with: ['inscription' => $this->inscription],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
