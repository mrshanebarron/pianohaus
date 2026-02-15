<?php

namespace App\Mail;

use App\Models\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RentalApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Rental $rental) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rental Approved — ' . $this->rental->rental_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.rental-approved',
            with: [
                'rental' => $this->rental->load('customer', 'piano', 'contract'),
            ],
        );
    }
}
