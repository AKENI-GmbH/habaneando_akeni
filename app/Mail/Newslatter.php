<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use App\Models\Customer;

class Newslatter extends Mailable
{
    use Queueable, SerializesModels;
    public string $reason;
    public string $content;
    public Customer $customer;

    /**
     * Create a new message instance.
     */
    public function __construct(string $reason, string $content, Customer $customer)
    {
        $this->subject = $reason;
        $this->content = $content;
        $this->customer = $customer;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.newslatter',
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
