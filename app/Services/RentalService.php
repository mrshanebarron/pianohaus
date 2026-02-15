<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\Piano;
use App\Models\Rental;
use Illuminate\Support\Facades\DB;

class RentalService
{
    public function __construct(
        private StatusTransitionService $statusService
    ) {}

    public function apply(Piano $piano, Customer $customer, array $data): Rental
    {
        if (!$piano->canBeRented()) {
            throw new \RuntimeException('This piano is not available for rent.');
        }

        return DB::transaction(function () use ($piano, $customer, $data) {
            $depositMultiplier = config('pianohaus.rental.deposit_multiplier');

            $rental = Rental::create([
                'customer_id' => $customer->id,
                'piano_id' => $piano->id,
                'rental_number' => Rental::generateRentalNumber(),
                'status' => 'pending_application',
                'monthly_rate' => $piano->rental_price_monthly,
                'deposit_amount' => $piano->rental_price_monthly * $depositMultiplier,
                'start_date' => $data['start_date'] ?? null,
                'end_date' => $data['end_date'] ?? null,
                'minimum_end_date' => isset($data['start_date'])
                    ? \Carbon\Carbon::parse($data['start_date'])->addMonths($piano->rental_minimum_months)
                    : null,
                'delivery_address' => $data['delivery_address'] ?? null,
                'application_notes' => $data['application_notes'] ?? null,
            ]);

            ActivityLog::log($rental, 'created', "Rental application submitted for {$piano->name}");

            return $rental;
        });
    }

    public function approve(Rental $rental): void
    {
        DB::transaction(function () use ($rental) {
            $this->statusService->transition($rental, 'approved');
            $rental->update([
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);
        });
    }

    public function deny(Rental $rental, ?string $reason = null): void
    {
        DB::transaction(function () use ($rental, $reason) {
            $this->statusService->transition($rental, 'denied');
            if ($reason) {
                $rental->update(['admin_notes' => $reason]);
            }
        });
    }

    public function activate(Rental $rental): void
    {
        DB::transaction(function () use ($rental) {
            $this->statusService->transition($rental, 'active');
            $rental->update([
                'next_payment_date' => $rental->start_date?->addMonth(),
            ]);
            $rental->piano->markAsRented();
        });
    }

    public function complete(Rental $rental, ?string $returnCondition = null): void
    {
        DB::transaction(function () use ($rental, $returnCondition) {
            $this->statusService->transition($rental, 'completed');
            $rental->update([
                'return_date' => now(),
                'return_condition' => $returnCondition,
            ]);
            $rental->piano->markAsAvailable();
        });
    }
}
