<?php

return [
    'company' => [
        'name' => 'PianoHaus',
        'tagline' => 'Fine Used Pianos — Owned or Rented',
        'email' => 'info@pianohaus.com',
        'phone' => '(615) 555-0142',
        'address' => '1847 Music Row, Nashville, TN 37203',
    ],

    'tax_rate' => 0.0825, // 8.25%

    'rental' => [
        'minimum_months' => 3,
        'deposit_multiplier' => 2, // deposit = 2x monthly rate
        'grace_period_days' => 5,
        'rent_to_own_credit' => 0.50, // 50% of rental payments credit toward purchase
    ],

    'delivery' => [
        'base_fee' => 15000, // $150 in cents
        'per_mile_fee' => 200, // $2/mile in cents
        'free_delivery_radius' => 25, // miles
        'time_slots' => ['9am-12pm', '12pm-3pm', '3pm-6pm'],
    ],

    'inventory' => [
        'conditions' => [
            'excellent' => 'Excellent — Like New',
            'very_good' => 'Very Good — Minor Wear',
            'good' => 'Good — Normal Wear',
            'fair' => 'Fair — Visible Wear',
            'needs_restoration' => 'Needs Restoration',
        ],
    ],
];
