<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@pianohaus.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Demo customer accounts
        $customers = [
            ['name' => 'Sarah Mitchell', 'email' => 'sarah@example.com'],
            ['name' => 'James Chen', 'email' => 'james@example.com'],
            ['name' => 'Emily Rodriguez', 'email' => 'emily@example.com'],
        ];

        foreach ($customers as $customer) {
            User::create(array_merge($customer, [
                'password' => Hash::make('password'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]));
        }
    }
}
