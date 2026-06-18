<?php

namespace App\Mail;

use App\Models\TestSession;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewCoupleMail extends Mailable
{
    use Queueable, SerializesModels;

    public TestSession $session;
    private string $pdfContent;

    public function __construct(
        TestSession $session,
        string $pdfContent
    ) {
        $this->session = $session;
        $this->pdfContent = $pdfContent;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nikoh testi natijalari',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.new_couple',
            with: [
                'session' => $this->session,
            ]
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(
                fn() => $this->pdfContent,
                'nikoh_test_natijalari_' . $this->session->id . '.pdf'
            )->withMime('application/pdf'),
        ];
    }
}
