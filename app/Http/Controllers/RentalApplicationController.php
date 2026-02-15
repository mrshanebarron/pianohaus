<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Piano;
use App\Services\RentalService;
use Illuminate\Http\Request;

class RentalApplicationController extends Controller
{
    public function __construct(
        private RentalService $rentalService
    ) {}

    public function create(Piano $piano)
    {
        if (!$piano->canBeRented()) {
            return redirect()->route('piano.show', $piano)->with('error', 'This piano is not available for rent.');
        }

        $rentalTerms = config('pianohaus.rental');

        return view('storefront.rental-apply', compact('piano', 'rentalTerms'));
    }

    public function store(Request $request, Piano $piano)
    {
        if (!$piano->canBeRented()) {
            return redirect()->route('piano.show', $piano)->with('error', 'This piano is not available for rent.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'start_date' => 'required|date|after:today',
            'duration_months' => 'required|integer|min:' . config('pianohaus.rental.minimum_months'),
            'application_notes' => 'nullable|string|max:1000',
        ]);

        $customer = Customer::firstOrCreate(
            ['email' => $validated['email']],
            [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'address_line_1' => $validated['address_line_1'],
                'address_line_2' => $validated['address_line_2'] ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip' => $validated['zip'],
            ]
        );

        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = $startDate->copy()->addMonths((int) $validated['duration_months']);

        $rental = $this->rentalService->apply($piano, $customer, [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'delivery_address' => [
                'line_1' => $validated['address_line_1'],
                'line_2' => $validated['address_line_2'] ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip' => $validated['zip'],
            ],
            'application_notes' => $validated['application_notes'] ?? null,
        ]);

        return redirect()->route('rental.confirmation', $rental->rental_number)
            ->with('success', 'Rental application submitted! We\'ll review and contact you within 24 hours.');
    }

    public function confirmation(string $rentalNumber)
    {
        $rental = \App\Models\Rental::where('rental_number', $rentalNumber)
            ->with(['piano.brand', 'customer'])
            ->firstOrFail();

        return view('storefront.rental-confirmation', compact('rental'));
    }
}
