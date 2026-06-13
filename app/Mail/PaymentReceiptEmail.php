<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReceiptEmail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $plainPassword;
    public string $pdfContent;
    public string $pdfName;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $plainPassword, string $pdfContent, string $pdfName)
    {
        $this->user = $user;
        $this->plainPassword = $plainPassword;
        $this->pdfContent = $pdfContent;
        $this->pdfName = $pdfName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation d\'inscription et Reçu de paiement - HOREB ACADEMY',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.receipt',
            with: [
                'user' => $this->user,
                'password' => $this->plainPassword,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, $this->pdfName)
                    ->withMime('application/pdf'),
        ];
    }
}
