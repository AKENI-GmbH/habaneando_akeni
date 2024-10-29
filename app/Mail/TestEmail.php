<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName; // Property to hold the user's name
    public $body; // Property to hold the main body content
    public $closingMessage; // Property for closing message

    /**
     * Create a new message instance.
     */
    public function __construct(string $userName, string $body, string $closingMessage)
    {
        $this->userName = $userName; // Set the user's name
        $this->body = $body; // Set the body content
        $this->closingMessage = $closingMessage; // Set the closing message
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Test Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.test_email',
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