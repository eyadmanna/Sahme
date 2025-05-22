<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendGenericMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $body_data;
    public $view_file;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $body_data, $view_file)
    {
        $this->subject = $subject;
        $this->body_data = $body_data;
        $this->view_file = $view_file;
        //dd($body_data['user']->name);
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
            view: $this->view_file,
            with: [
                'subject' => $this->subject,
                'body_data' => $this->body_data,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
