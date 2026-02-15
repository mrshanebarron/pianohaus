<?php

namespace App\Mail;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContractReady extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Contract $contract) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contract Ready for Signature — ' . $this->contract->contract_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contract-ready',
            with: [
                'contract' => $this->contract->load('customer', 'rental.piano'),
            ],
        );
    }
}
