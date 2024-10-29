<?php

namespace App\Mail;

use App\Models\CourseSubscription;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PurchaseConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;

    public function __construct(CourseSubscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bestätigung Ihrer Buchung bei Salsa Tanzschule Habaneando',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.purchase_confirmation',
        );
    }
}