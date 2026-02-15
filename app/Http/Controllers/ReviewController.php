<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Piano;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Piano $piano)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:200',
            'body' => 'required|string|max:2000',
        ]);

        // Find or create a customer record for the reviewer
        $customer = Customer::firstOrCreate(
            ['email' => $validated['email']],
            [
                'first_name' => explode(' ', $validated['name'])[0],
                'last_name' => implode(' ', array_slice(explode(' ', $validated['name']), 1)) ?: '',
            ]
        );

        $piano->reviews()->create([
            'customer_id' => $customer->id,
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'body' => $validated['body'],
            'is_approved' => false,
            'is_verified_purchase' => $customer->orders()
                ->whereHas('items', fn ($q) => $q->where('piano_id', $piano->id))
                ->exists(),
        ]);

        return back()->with('success', 'Thank you for your review! It will appear after moderation.');
    }
}
