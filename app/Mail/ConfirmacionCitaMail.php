<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmacionCitaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $services;
    public $date;
    public $time;
    public $price;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $services, $date, $time, $price)
    {
        $this->user = $user;
        $this->services = $services;
        $this->date = $date;
        $this->time = $time;
        $this->price = $price;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmacion Cita',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.confirmacion_cita',
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
