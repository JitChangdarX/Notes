<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Contact Form Submission',
            to: ['jitchangdar@gmail.com'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.contact_form',
            with: ['data' => $this->data],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}