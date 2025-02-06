<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComposeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $attachmentPath;

    public function __construct($message, $attachmentPath = null)
    {
        $this->message = (string) $message; // Ensuring $message is a string
        $this->attachmentPath = $attachmentPath;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Message',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.send', // Specify the view that will display the message
            with: [
                'body' => $this->message,
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
        $attachments = [];

        // Attach file if present
        if ($this->attachmentPath) {
            $attachments[] = Attachment::fromPath(public_path('files/' . $this->attachmentPath)); // Attach file if exists
        }

        return $attachments;
    }
}
