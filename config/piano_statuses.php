<?php

return [
    'piano' => [
        'available' => ['reserved', 'maintenance', 'retired'],
        'reserved' => ['available', 'sold', 'rented'],
        'sold' => ['available'],
        'rented' => ['available'],
        'maintenance' => ['available', 'retired'],
        'retired' => [],
    ],

    'order' => [
        'pending' => ['confirmed', 'cancelled'],
        'confirmed' => ['processing', 'cancelled'],
        'processing' => ['ready_for_delivery', 'cancelled'],
        'ready_for_delivery' => ['delivered'],
        'delivered' => ['completed'],
        'completed' => ['refunded'],
        'cancelled' => [],
        'refunded' => [],
    ],

    'rental' => [
        'pending_application' => ['approved', 'denied'],
        'approved' => ['active', 'cancelled'],
        'active' => ['past_due', 'completed', 'suspended'],
        'past_due' => ['active', 'suspended', 'completed'],
        'suspended' => ['active', 'completed'],
        'completed' => [],
        'cancelled' => [],
        'denied' => [],
    ],
];
