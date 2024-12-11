<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public function __construct() {}

    public function build()
    {
        return $this->view('emails.contact-test');
    }


    public function envelope()
    {
        return new Envelope(
            subject: 'Contact Mail',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.contact-test',
        );
    }

    public function attachments()
    {
        return [];
    }


    public function __toString()
    {
        return 'ContactMail';
    }


    public function test()
    {
        return 'test';
    }
}
