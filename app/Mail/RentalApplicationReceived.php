<?php

namespace App\Mail;

use App\Models\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RentalApplicationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Rental $rental) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rental Application Received — ' . $this->rental->rental_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.rental-application-received',
            with: [
                'rental' => $this->rental->load('customer', 'piano'),
            ],
        );
    }
}
