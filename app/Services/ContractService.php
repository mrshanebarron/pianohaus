<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\Rental;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ContractService
{
    public function createForRental(Rental $rental): Contract
    {
        $rental->load(['piano.brand', 'customer']);

        $content = view('pdf.contract-content', [
            'rental' => $rental,
            'company' => config('pianohaus.company'),
            'rentalTerms' => config('pianohaus.rental'),
        ])->render();

        $contract = Contract::create([
            'rental_id' => $rental->id,
            'customer_id' => $rental->customer_id,
            'contract_number' => Contract::generateContractNumber(),
            'type' => 'rental_agreement',
            'status' => 'sent',
            'content' => $content,
            'valid_from' => $rental->start_date,
            'valid_until' => $rental->end_date,
            'sent_at' => now(),
        ]);

        $rental->update(['contract_id' => $contract->id]);

        $this->generatePdf($contract);

        return $contract;
    }

    public function recordSignature(Contract $contract, string $signatureData, string $ip): void
    {
        $contract->update([
            'customer_signature' => $signatureData,
            'customer_signed_at' => now(),
            'customer_ip' => $ip,
            'status' => 'signed',
        ]);

        // Regenerate PDF with signature
        $this->generatePdf($contract);
    }

    public function generatePdf(Contract $contract): string
    {
        $contract->load(['rental.piano.brand', 'customer']);

        $pdf = Pdf::loadView('pdf.contract', [
            'contract' => $contract,
            'company' => config('pianohaus.company'),
        ]);

        $path = "contracts/{$contract->contract_number}.pdf";
        Storage::disk('local')->put($path, $pdf->output());

        $contract->update(['pdf_path' => $path]);

        return $path;
    }
}
