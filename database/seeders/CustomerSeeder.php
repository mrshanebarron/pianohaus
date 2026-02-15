<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            ['first_name' => 'Sarah', 'last_name' => 'Mitchell', 'email' => 'sarah@example.com', 'phone' => '(615) 555-0123', 'address_line_1' => '412 Broadway', 'city' => 'Nashville', 'state' => 'TN', 'zip' => '37203'],
            ['first_name' => 'James', 'last_name' => 'Chen', 'email' => 'james@example.com', 'phone' => '(615) 555-0456', 'address_line_1' => '890 West End Ave', 'city' => 'Nashville', 'state' => 'TN', 'zip' => '37205'],
            ['first_name' => 'Emily', 'last_name' => 'Rodriguez', 'email' => 'emily@example.com', 'phone' => '(615) 555-0789', 'address_line_1' => '2301 12th Ave S', 'city' => 'Nashville', 'state' => 'TN', 'zip' => '37204'],
            ['first_name' => 'Michael', 'last_name' => 'Thompson', 'email' => 'michael@example.com', 'phone' => '(615) 555-0321', 'address_line_1' => '1501 Demonbreun St', 'city' => 'Nashville', 'state' => 'TN', 'zip' => '37203'],
            ['first_name' => 'Lisa', 'last_name' => 'Park', 'email' => 'lisa@example.com', 'phone' => '(615) 555-0654', 'address_line_1' => '744 Gallatin Ave', 'city' => 'Nashville', 'state' => 'TN', 'zip' => '37206'],
            ['first_name' => 'David', 'last_name' => 'Williams', 'email' => 'david@example.com', 'phone' => '(615) 555-0987', 'address_line_1' => '3900 Hillsboro Pike', 'city' => 'Nashville', 'state' => 'TN', 'zip' => '37215'],
            ['first_name' => 'Maria', 'last_name' => 'Garcia', 'email' => 'maria@example.com', 'phone' => '(615) 555-0147', 'address_line_1' => '1817 Division St', 'city' => 'Nashville', 'state' => 'TN', 'zip' => '37203'],
            ['first_name' => 'Robert', 'last_name' => 'Johnson', 'email' => 'robert@example.com', 'phone' => '(615) 555-0258', 'address_line_1' => '520 Church St', 'city' => 'Nashville', 'state' => 'TN', 'zip' => '37219'],
            ['first_name' => 'Anna', 'last_name' => 'Kim', 'email' => 'anna@example.com', 'phone' => '(615) 555-0369', 'address_line_1' => '2209 Belmont Blvd', 'city' => 'Nashville', 'state' => 'TN', 'zip' => '37212'],
            ['first_name' => 'Thomas', 'last_name' => 'Davis', 'email' => 'thomas@example.com', 'phone' => '(615) 555-0470', 'address_line_1' => '1111 8th Ave S', 'city' => 'Nashville', 'state' => 'TN', 'zip' => '37203'],
        ];

        foreach ($customers as $data) {
            $user = User::where('email', $data['email'])->first();
            Customer::create(array_merge($data, [
                'user_id' => $user?->id,
                'is_verified' => $user !== null,
            ]));
        }
    }
}
