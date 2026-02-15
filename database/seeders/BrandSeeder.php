<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Steinway & Sons', 'description' => 'The gold standard in concert grand pianos since 1853. Handcrafted in New York and Hamburg with over 12,000 parts per instrument.'],
            ['name' => 'Yamaha', 'description' => 'The world\'s largest musical instrument manufacturer. Known for consistent quality across every price point, from student uprights to concert grands.'],
            ['name' => 'Kawai', 'description' => 'Japanese precision meets European tradition. Kawai\'s Millennium III carbon-fiber action delivers unmatched responsiveness.'],
            ['name' => 'Baldwin', 'description' => 'America\'s favorite piano for over a century. Bold, powerful tone that fills concert halls and living rooms alike.'],
            ['name' => 'Roland', 'description' => 'Pioneer of digital piano technology. SuperNATURAL modeling delivers acoustic authenticity with digital convenience.'],
            ['name' => 'Bösendorfer', 'description' => 'Vienna\'s legendary piano maker since 1828. The Imperial Grand\'s 97 keys unlock the deepest bass frequencies in the piano world.'],
            ['name' => 'Mason & Hamlin', 'description' => 'Boston\'s finest since 1854. The tension resonator design produces a rich, singing tone prized by discerning pianists.'],
            ['name' => 'Casio', 'description' => 'Making quality digital pianos accessible. Tri-sensor scaled hammer action brings authentic feel to every budget.'],
        ];

        foreach ($brands as $i => $brand) {
            Brand::create(array_merge($brand, ['sort_order' => $i]));
        }
    }
}
