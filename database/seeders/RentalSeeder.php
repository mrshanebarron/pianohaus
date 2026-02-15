<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\LedgerEntry;
use App\Models\Payment;
use App\Models\Piano;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Database\Seeder;

class RentalSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $rentalPianos = Piano::whereIn('type', ['rental', 'both'])->where('status', 'available')->get();
        $admin = User::where('role', 'admin')->first();
        $runningBalance = LedgerEntry::max('running_balance') ?? 0;

        $rentals = [
            // Active rental — Yamaha B2
            [
                'customer_index' => 3, 'piano_index' => 15,
                'status' => 'active', 'months_ago' => 4,
                'application_notes' => 'Daughter started piano lessons. Looking for a quality student instrument for 6-12 months to see if she sticks with it.',
            ],
            // Active rental — Roland HP-704
            [
                'customer_index' => 5, 'piano_index' => 13,
                'status' => 'active', 'months_ago' => 2,
                'application_notes' => 'Need a digital piano for apartment practice. Neighbors are sensitive to noise. Headphone capability essential.',
            ],
            // Active rental — Kawai K-300
            [
                'customer_index' => 7, 'piano_index' => 16,
                'status' => 'active', 'months_ago' => 6,
                'application_notes' => 'Intermediate player preparing for conservatory auditions. Need a professional-quality upright for serious practice.',
            ],
            // Pending application — Yamaha U3
            [
                'customer_index' => 8, 'piano_index' => 6,
                'status' => 'pending_application', 'months_ago' => 0,
                'application_notes' => 'Retired teacher wanting to get back into playing. Looking for a familiar, reliable instrument.',
            ],
            // Completed rental
            [
                'customer_index' => 9, 'piano_index' => 4,
                'status' => 'completed', 'months_ago' => 8,
                'completed_months_ago' => 2,
                'application_notes' => 'Renting while deciding what to buy. Ended up purchasing a different piano.',
            ],
        ];

        foreach ($rentals as $rentalData) {
            $customer = $customers[$rentalData['customer_index']];
            $piano = $rentalPianos[$rentalData['piano_index']] ?? $rentalPianos->random();
            $monthlyRate = $piano->rental_price_monthly;
            $depositAmount = $piano->rental_deposit ?? ($monthlyRate * 2);

            $startDate = now()->subMonths($rentalData['months_ago']);
            $endDate = $rentalData['status'] === 'completed'
                ? now()->subMonths($rentalData['completed_months_ago'] ?? 1)
                : null;

            $isApproved = in_array($rentalData['status'], ['active', 'completed']);

            $rental = Rental::create([
                'customer_id' => $customer->id,
                'piano_id' => $piano->id,
                'rental_number' => Rental::generateRentalNumber(),
                'status' => $rentalData['status'],
                'monthly_rate' => $monthlyRate,
                'deposit_amount' => $depositAmount,
                'deposit_paid' => $isApproved,
                'start_date' => $isApproved ? $startDate : null,
                'end_date' => $endDate,
                'minimum_end_date' => $isApproved ? $startDate->copy()->addMonths(3) : null,
                'next_payment_date' => $rentalData['status'] === 'active' ? now()->addDays(rand(1, 28)) : null,
                'delivery_address' => [
                    'line_1' => $customer->address_line_1,
                    'city' => $customer->city,
                    'state' => $customer->state,
                    'zip' => $customer->zip,
                ],
                'application_notes' => $rentalData['application_notes'],
                'approved_at' => $isApproved ? $startDate->copy()->subDays(2) : null,
                'approved_by' => $isApproved ? $admin->id : null,
                'created_at' => $rentalData['status'] === 'pending_application' ? now() : $startDate->copy()->subDays(5),
            ]);

            // Mark piano as rented for active rentals
            if ($rentalData['status'] === 'active') {
                $piano->update(['status' => 'rented']);
            }

            // Create payments for active/completed rentals
            if ($isApproved) {
                // Deposit payment
                $depositPayment = Payment::create([
                    'customer_id' => $customer->id,
                    'rental_id' => $rental->id,
                    'amount' => $depositAmount,
                    'type' => 'rental_deposit',
                    'status' => 'completed',
                    'method' => 'stripe',
                    'stripe_payment_id' => 'pi_dep_' . strtolower(str_replace('-', '', substr(fake()->uuid(), 0, 13))),
                    'paid_at' => $startDate->copy()->subDay(),
                ]);

                $runningBalance += $depositAmount;
                LedgerEntry::create([
                    'payment_id' => $depositPayment->id,
                    'rental_id' => $rental->id,
                    'customer_id' => $customer->id,
                    'type' => 'rental_deposit',
                    'amount' => $depositAmount,
                    'running_balance' => $runningBalance,
                    'description' => "Rental deposit for {$rental->rental_number}",
                    'reference' => $depositPayment->stripe_payment_id,
                    'created_at' => $startDate->copy()->subDay(),
                ]);

                // Monthly payments
                $monthsPaid = $rentalData['status'] === 'completed'
                    ? $rentalData['months_ago'] - ($rentalData['completed_months_ago'] ?? 1)
                    : $rentalData['months_ago'];

                for ($m = 0; $m < $monthsPaid; $m++) {
                    $paymentDate = $startDate->copy()->addMonths($m);

                    $monthlyPayment = Payment::create([
                        'customer_id' => $customer->id,
                        'rental_id' => $rental->id,
                        'amount' => $monthlyRate,
                        'type' => 'rental_monthly',
                        'status' => 'completed',
                        'method' => 'stripe',
                        'stripe_payment_id' => 'pi_rnt_' . strtolower(str_replace('-', '', substr(fake()->uuid(), 0, 10))) . '_' . $m,
                        'paid_at' => $paymentDate,
                    ]);

                    $runningBalance += $monthlyRate;
                    LedgerEntry::create([
                        'payment_id' => $monthlyPayment->id,
                        'rental_id' => $rental->id,
                        'customer_id' => $customer->id,
                        'type' => 'rental_payment',
                        'amount' => $monthlyRate,
                        'running_balance' => $runningBalance,
                        'description' => "Monthly rental payment for {$rental->rental_number} (month " . ($m + 1) . ")",
                        'reference' => $monthlyPayment->stripe_payment_id,
                        'created_at' => $paymentDate,
                    ]);
                }

                // Deposit refund for completed rentals
                if ($rentalData['status'] === 'completed') {
                    $refundPayment = Payment::create([
                        'customer_id' => $customer->id,
                        'rental_id' => $rental->id,
                        'amount' => $depositAmount,
                        'type' => 'refund',
                        'status' => 'completed',
                        'method' => 'stripe',
                        'stripe_payment_id' => 'pi_ref_' . strtolower(str_replace('-', '', substr(fake()->uuid(), 0, 13))),
                        'paid_at' => $endDate,
                    ]);

                    $runningBalance -= $depositAmount;
                    LedgerEntry::create([
                        'payment_id' => $refundPayment->id,
                        'rental_id' => $rental->id,
                        'customer_id' => $customer->id,
                        'type' => 'refund',
                        'amount' => -$depositAmount,
                        'running_balance' => $runningBalance,
                        'description' => "Deposit refund for {$rental->rental_number}",
                        'reference' => $refundPayment->stripe_payment_id,
                        'created_at' => $endDate,
                    ]);
                }

                // Create contract for active/completed rentals
                Contract::create([
                    'rental_id' => $rental->id,
                    'customer_id' => $customer->id,
                    'contract_number' => Contract::generateContractNumber(),
                    'type' => 'rental_agreement',
                    'status' => 'signed',
                    'content' => $this->generateContractContent($rental, $customer, $piano),
                    'customer_signed_at' => $startDate->copy()->subDay(),
                    'customer_ip' => '192.168.1.' . rand(2, 254),
                ]);
            }
        }
    }

    private function generateContractContent(Rental $rental, $customer, Piano $piano): string
    {
        return <<<EOT
PIANO RENTAL AGREEMENT

This Rental Agreement ("Agreement") is entered into between PianoHaus ("Lessor") and {$customer->full_name} ("Lessee").

INSTRUMENT DETAILS
- Piano: {$piano->name}
- Serial Number: {$piano->serial_number}
- Condition at Delivery: {$piano->condition}

RENTAL TERMS
- Monthly Rate: \${$rental->formatted_monthly_rate}
- Security Deposit: \${$rental->formatted_deposit}
- Minimum Term: 3 months
- Start Date: {$rental->start_date?->format('F j, Y')}

RESPONSIBILITIES
The Lessee agrees to:
1. Maintain the instrument in a climate-controlled environment (65-75°F, 40-60% humidity)
2. Not move the instrument from the delivery address without written consent
3. Allow access for scheduled tuning and maintenance
4. Report any damage immediately
5. Return the instrument in the same condition, normal wear excepted

RENT-TO-OWN OPTION
50% of rental payments may be applied toward purchase of this instrument, subject to availability and current pricing.

TERMINATION
Either party may terminate this agreement with 30 days written notice after the minimum term has been fulfilled. Early termination requires payment of remaining months in the minimum term.
EOT;
    }
}
