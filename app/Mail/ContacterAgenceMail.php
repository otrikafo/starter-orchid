<?php

namespace App\Mail;

use App\Models\Agence;
use App\Models\Bien;
use App\Models\Visiteur;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContacterAgenceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Visiteur $visiteur, public  Agence $agence, public Bien $bien, public string $message)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contacter Agence Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.agence.contact', // Nom du template Blade
            with: [
                'agence' => $this->agence, // Passer le agence au template,
                'visiteur' => $this->visiteur, // Passer le visiteur au template
                'message' => $this->message, // Passer le message au template
                'bien' => $this->bien, // Passer le bien au template
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
