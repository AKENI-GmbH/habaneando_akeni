<?php

namespace App\Mail;

use App\Models\Course;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class CourseGlobalNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $course;
    public $subjectLine;
    public $bodyMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(Course $course, $subject, $body)
    {
        $this->course = $course;
        $this->subjectLine = $subject;
        $this->bodyMessage = $body;
    }

    /**
     * Get the message envelope.
     *
     * This sets the subject of the email.
     *
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
        );
    }


    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.courses.notification',
            with: [
                'course' => $this->course,
                'bodyMessage' => $this->bodyMessage,
            ],
        );
    }


    /**
     * Get the attachments for the message.
     *
     * Here you can add attachments to the email.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
