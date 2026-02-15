<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            PianoSeeder::class,
            CustomerSeeder::class,
            ReviewSeeder::class,
            OrderSeeder::class,
            RentalSeeder::class,
        ]);
    }
}
