<?php

namespace App\Mail;

use App\Models\Inscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DossierRejeteEmail extends Mailable
{
    use Queueable, SerializesModels;

    public Inscription $inscription;
    public string $motif;
    public bool $modifiable;

    public function __construct(Inscription $inscription, string $motif, bool $modifiable = false)
    {
        $this->inscription = $inscription;
        $this->motif       = $motif;
        $this->modifiable  = $modifiable;
    }

    public function envelope(): Envelope
    {
        $subject = $this->modifiable
            ? '⚠️ Votre dossier nécessite des modifications — HOREB ACADEMY'
            : '❌ Décision concernant votre dossier — HOREB ACADEMY';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.dossier-rejete',
            with: [
                'inscription' => $this->inscription,
                'motif'       => $this->motif,
                'modifiable'  => $this->modifiable,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
