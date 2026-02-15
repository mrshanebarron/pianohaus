<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Piano;
use App\Models\PianoPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PianoSeeder extends Seeder
{
    public function run(): void
    {
        $brands = Brand::all()->keyBy('name');
        $categories = Category::all()->keyBy('name');

        $pianos = [
            // Grand Pianos
            [
                'brand' => 'Steinway & Sons', 'category' => 'Grand Piano',
                'name' => 'Steinway Model D Concert Grand', 'year' => 2019,
                'condition' => 'excellent', 'finish' => 'Ebony Satin',
                'sale_price' => 12500000, 'original_price' => 17100000,
                'rental_price_monthly' => 125000, 'rental_deposit' => 250000,
                'type' => 'both', 'is_featured' => true, 'is_certified' => true,
                'short_description' => 'The legendary 8\'11" concert grand. Recently serviced with new hammers.',
                'description' => "This magnificent Steinway Model D represents the pinnacle of piano craftsmanship. At 8 feet 11 inches, it delivers the full, resonant tone that has made Steinway the choice of concert halls worldwide.\n\nThis particular instrument was previously owned by a private collector and has seen minimal use. The action has been recently regulated and voiced, with new Renner hammers installed. The ebony satin finish is in immaculate condition with no visible wear.\n\nIncludes a matching adjustable artist bench, full piano cover, and complimentary first tuning after delivery.",
                'features' => ['Accelerated Action', 'Diaphragmatic Soundboard', 'Hexagrip Pinblock', 'Renner Hammers (New)'],
                'includes' => ['Artist Bench', 'Piano Cover', 'First Tuning', 'White Glove Delivery'],
                'dimensions' => ['length' => '8\'11"', 'width' => '5\'2"', 'weight' => '990 lbs'],
                'serial_number' => 'SD-601247',
            ],
            [
                'brand' => 'Yamaha', 'category' => 'Grand Piano',
                'name' => 'Yamaha C7X Concert Grand', 'year' => 2021,
                'condition' => 'excellent', 'finish' => 'Polished Ebony',
                'sale_price' => 6800000, 'original_price' => 8500000,
                'rental_price_monthly' => 85000, 'rental_deposit' => 170000,
                'type' => 'both', 'is_featured' => true, 'is_certified' => true,
                'short_description' => 'Yamaha\'s flagship 7\'6" grand. CX Series with concert-quality projection.',
                'description' => "The Yamaha C7X is the instrument of choice for concert venues and recording studios around the world. At 7 feet 6 inches, it offers extraordinary tonal depth and projection that rivals instruments costing three times as much.\n\nThis C7X is from Yamaha's latest CX series, featuring a redesigned soundboard and improved action geometry. The polished ebony finish is flawless. Previously used in a private teaching studio with meticulous care.",
                'features' => ['CX Series Soundboard', 'Ivorite Keytops', 'Sostenuto Pedal', 'Duplex Scale'],
                'includes' => ['Matching Bench', 'Piano Cover', 'First Tuning'],
                'dimensions' => ['length' => '7\'6"', 'width' => '5\'1"', 'weight' => '849 lbs'],
                'serial_number' => 'YC7-6412890',
            ],
            [
                'brand' => 'Kawai', 'category' => 'Grand Piano',
                'name' => 'Kawai GX-7 Concert Grand', 'year' => 2020,
                'condition' => 'very_good', 'finish' => 'Polished Ebony',
                'sale_price' => 5200000, 'rental_price_monthly' => 65000, 'rental_deposit' => 130000,
                'type' => 'both', 'is_featured' => false, 'is_certified' => true,
                'short_description' => 'Kawai\'s 7\'6" flagship with Millennium III carbon-fiber action.',
                'description' => "The Kawai GX-7 represents decades of Japanese engineering excellence. Its Millennium III action, featuring carbon-fiber composite parts, delivers faster repetition and lighter touch than traditional wooden actions.\n\nThis instrument shows minor wear consistent with careful use in a home setting. The tone is warm and singing, with excellent sustain across all registers.",
                'features' => ['Millennium III Action', 'Carbon Fiber Parts', 'Dual Trapwork', 'Extended Pinblock'],
                'includes' => ['Matching Bench', 'First Tuning'],
                'dimensions' => ['length' => '7\'6"', 'width' => '5\'1"', 'weight' => '838 lbs'],
                'serial_number' => 'KGX7-283741',
            ],

            // Baby Grand Pianos
            [
                'brand' => 'Steinway & Sons', 'category' => 'Baby Grand',
                'name' => 'Steinway Model M Baby Grand', 'year' => 2015,
                'condition' => 'very_good', 'finish' => 'Mahogany Satin',
                'sale_price' => 4800000, 'original_price' => 6500000,
                'rental_price_monthly' => 55000, 'rental_deposit' => 110000,
                'type' => 'both', 'is_featured' => true,
                'short_description' => 'The classic 5\'7" living room grand in warm mahogany.',
                'description' => "The Steinway Model M has been the quintessential home grand piano for generations. At 5 feet 7 inches, it fits gracefully in living rooms and music rooms while delivering the unmistakable Steinway sound.\n\nThis mahogany satin example shows the natural warmth of the wood grain beautifully. The action is responsive and the tone is rich and balanced across all registers.",
                'features' => ['Accelerated Action', 'Diaphragmatic Soundboard', 'Mahogany Rim'],
                'includes' => ['Matching Bench', 'Piano Cover', 'First Tuning', 'Humidity Control System'],
                'dimensions' => ['length' => '5\'7"', 'width' => '4\'10"', 'weight' => '540 lbs'],
                'serial_number' => 'SM-589341',
            ],
            [
                'brand' => 'Yamaha', 'category' => 'Baby Grand',
                'name' => 'Yamaha GB1K Baby Grand', 'year' => 2022,
                'condition' => 'excellent', 'finish' => 'Polished Ebony',
                'sale_price' => 1600000, 'rental_price_monthly' => 25000, 'rental_deposit' => 50000,
                'type' => 'both', 'is_featured' => false,
                'short_description' => 'Yamaha\'s most affordable 5\' grand. Perfect entry into grand piano ownership.',
                'description' => "The GB1K proves that grand piano ownership doesn't have to break the bank. At just 5 feet, it's Yamaha's most compact grand, yet it delivers surprising tonal depth thanks to Yamaha's decades of acoustic research.\n\nNearly new condition with minimal play time. The polished ebony finish gleams. A perfect first grand piano for students or space-conscious musicians.",
                'features' => ['V-Pro Plate', 'Spruce Soundboard', 'Soft-Close Fallboard'],
                'includes' => ['Matching Bench', 'First Tuning'],
                'dimensions' => ['length' => '5\'0"', 'width' => '4\'10"', 'weight' => '672 lbs'],
                'serial_number' => 'YGB1-7823401',
            ],
            [
                'brand' => 'Bösendorfer', 'category' => 'Baby Grand',
                'name' => 'Bösendorfer 170 Baby Grand', 'year' => 2018,
                'condition' => 'excellent', 'finish' => 'Polished Ebony',
                'sale_price' => 7500000, 'rental_price_monthly' => 95000, 'rental_deposit' => 190000,
                'type' => 'sale', 'is_featured' => true, 'is_certified' => true,
                'short_description' => 'Viennese craftsmanship in a 5\'8" frame. Legendary singing tone.',
                'description' => "The Bösendorfer 170 embodies the singing, warm tone that has made Vienna's oldest piano maker legendary. Unlike the brighter American and Japanese instruments, the Bösendorfer produces a uniquely rounded, colorful sound.\n\nThis instrument was owned by a professional pianist and maintained by a Bösendorfer-certified technician. The condition is exceptional.",
                'features' => ['Viennese Action', 'Spruce Soundboard', 'Capo d\'Astro Bar', 'Hand-Selected Wood'],
                'includes' => ['Artist Bench', 'Piano Cover', 'Certificate of Authenticity'],
                'dimensions' => ['length' => '5\'8"', 'width' => '4\'11"', 'weight' => '715 lbs'],
                'serial_number' => 'BOS170-50892',
            ],

            // Upright Pianos
            [
                'brand' => 'Yamaha', 'category' => 'Upright Piano',
                'name' => 'Yamaha U3 Professional Upright', 'year' => 2017,
                'condition' => 'very_good', 'finish' => 'Polished Ebony',
                'sale_price' => 850000, 'rental_price_monthly' => 15000, 'rental_deposit' => 30000,
                'type' => 'both', 'is_featured' => false,
                'short_description' => 'The legendary 52" studio upright. The industry standard for serious students.',
                'description' => "The Yamaha U3 is widely considered the finest production upright piano ever made. At 52 inches tall, it produces a surprisingly full, grand-like tone that has made it the go-to instrument for music schools and conservatories worldwide.\n\nThis U3 is in very good condition with a responsive, even action. The bass is deep and the treble sings clearly. An excellent choice for advanced students and professionals who need a reliable practice instrument.",
                'features' => ['52" Full-Size Upright', 'Spruce Soundboard', 'Aluminum Action Rail', 'Soft-Close Fallboard'],
                'includes' => ['Matching Bench'],
                'dimensions' => ['height' => '52"', 'width' => '60"', 'depth' => '26"', 'weight' => '531 lbs'],
                'serial_number' => 'YU3-6541238',
            ],
            [
                'brand' => 'Kawai', 'category' => 'Upright Piano',
                'name' => 'Kawai K-500 Upright', 'year' => 2020,
                'condition' => 'excellent', 'finish' => 'Ebony Satin',
                'sale_price' => 920000, 'rental_price_monthly' => 16000, 'rental_deposit' => 32000,
                'type' => 'both',
                'short_description' => 'Kawai\'s 51" professional upright with Millennium III action.',
                'description' => "The K-500 is Kawai's flagship upright, offering the same Millennium III action technology found in their grand pianos. The result is faster repetition and a more responsive touch than any competing upright.\n\nIn excellent condition with minimal use. The ebony satin finish is forgiving and elegant.",
                'features' => ['Millennium III Action', '51" Height', 'Solid Spruce Soundboard', 'NEOTEX Key Surfaces'],
                'includes' => ['Matching Bench', 'First Tuning'],
                'dimensions' => ['height' => '51"', 'width' => '59"', 'depth' => '24"', 'weight' => '530 lbs'],
                'serial_number' => 'KK5-198234',
            ],
            [
                'brand' => 'Baldwin', 'category' => 'Upright Piano',
                'name' => 'Baldwin Hamilton Studio Upright', 'year' => 2005,
                'condition' => 'good', 'finish' => 'Walnut Satin',
                'sale_price' => 320000, 'rental_price_monthly' => 8000, 'rental_deposit' => 16000,
                'type' => 'both',
                'short_description' => 'Classic American studio upright. Rich, warm Baldwin tone.',
                'description' => "The Baldwin Hamilton was a mainstay in American music studios for decades. This walnut satin example delivers the characteristically warm, full Baldwin tone.\n\nShows normal wear consistent with age but plays well. Recently tuned and regulated. A solid choice for students or casual players looking for real acoustic piano feel at an accessible price.",
                'features' => ['Studio Height 45"', 'Baldwin Tone', 'Walnut Cabinet'],
                'includes' => ['Bench'],
                'dimensions' => ['height' => '45"', 'width' => '58"', 'depth' => '24"', 'weight' => '475 lbs'],
                'serial_number' => 'BH-892341',
            ],
            [
                'brand' => 'Mason & Hamlin', 'category' => 'Upright Piano',
                'name' => 'Mason & Hamlin Model 50 Upright', 'year' => 2012,
                'condition' => 'very_good', 'finish' => 'Ebony Satin',
                'sale_price' => 1100000, 'rental_price_monthly' => 18000, 'rental_deposit' => 36000,
                'type' => 'sale', 'is_featured' => false, 'is_certified' => true,
                'short_description' => 'Boston\'s finest upright. Tension resonator for singing sustain.',
                'description' => "Mason & Hamlin's Model 50 is an upright piano that thinks it's a grand. The patented tension resonator technology produces a singing, sustained tone that few uprights can match.\n\nThis instrument has been meticulously maintained and shows only minor wear. The action is wonderfully responsive.",
                'features' => ['Tension Resonator', 'Crown Retention System', 'Premium Spruce Soundboard'],
                'includes' => ['Matching Bench', 'Certificate of Authenticity'],
                'dimensions' => ['height' => '50"', 'width' => '60"', 'depth' => '25"', 'weight' => '545 lbs'],
                'serial_number' => 'MH50-127834',
            ],

            // Digital Pianos
            [
                'brand' => 'Roland', 'category' => 'Digital Piano',
                'name' => 'Roland LX-708 Digital Grand', 'year' => 2023,
                'condition' => 'excellent', 'finish' => 'Polished Ebony',
                'sale_price' => 520000, 'rental_price_monthly' => 10000, 'rental_deposit' => 20000,
                'type' => 'both', 'is_featured' => true,
                'short_description' => 'Roland\'s flagship digital piano. PureAcoustic modeling and hybrid wooden keys.',
                'description' => "The LX-708 represents the absolute pinnacle of digital piano technology. Roland's PureAcoustic Piano Modeling doesn't use recordings — it mathematically models every element of an acoustic piano in real-time.\n\nThe Hybrid Grand keyboard uses real wooden keys with progressive hammer action. Eight speakers create an immersive 3D sound field. Virtually indistinguishable from a fine acoustic grand in blind testing.\n\nPerfect for apartments, late-night practice, or anyone who wants concert-quality sound with zero maintenance.",
                'features' => ['PureAcoustic Modeling', 'Hybrid Grand Keyboard', '8-Speaker System', 'Bluetooth Audio/MIDI', 'Headphone 3D Ambience'],
                'includes' => ['Integrated Stand', 'Three Pedals', 'Bench'],
                'dimensions' => ['height' => '45"', 'width' => '55"', 'depth' => '18"', 'weight' => '187 lbs'],
                'serial_number' => 'RL708-9923456',
            ],
            [
                'brand' => 'Yamaha', 'category' => 'Digital Piano',
                'name' => 'Yamaha CLP-785 Clavinova', 'year' => 2023,
                'condition' => 'excellent', 'finish' => 'Polished Ebony',
                'sale_price' => 450000, 'rental_price_monthly' => 8500, 'rental_deposit' => 17000,
                'type' => 'both',
                'short_description' => 'Yamaha\'s flagship Clavinova. CFX and Bösendorfer concert grand samples.',
                'description' => "The CLP-785 is Yamaha's top Clavinova, featuring binaural samples of both the Yamaha CFX and Bösendorfer Imperial concert grands. The GrandTouch-S wooden keyboard delivers the most realistic key feel in digital piano history.\n\nSpruce cone speakers and acoustic enclosure create a room-filling sound that's remarkably close to a real grand piano.",
                'features' => ['GrandTouch-S Keyboard', 'CFX & Bösendorfer Samples', 'Spruce Cone Speakers', 'GP Response Damper Pedal'],
                'includes' => ['Integrated Stand', 'Three Pedals', 'Bench'],
                'dimensions' => ['height' => '42"', 'width' => '57"', 'depth' => '18"', 'weight' => '165 lbs'],
                'serial_number' => 'YCLP-4521890',
            ],
            [
                'brand' => 'Casio', 'category' => 'Digital Piano',
                'name' => 'Casio GP-510 Celviano Grand Hybrid', 'year' => 2022,
                'condition' => 'excellent', 'finish' => 'Polished Ebony',
                'sale_price' => 350000, 'rental_price_monthly' => 7000, 'rental_deposit' => 14000,
                'type' => 'both',
                'short_description' => 'Real Bechstein action inside a digital piano. The hybrid that surprised everyone.',
                'description' => "The GP-510 shocked the piano world by putting a real C. Bechstein wooden grand piano action inside a digital piano cabinet. This isn't a simulation — it's actual wooden keys with real hammers.\n\nThree world-class piano sounds (Hamburg Grand, Berlin Grand, Vienna Grand) through a 6-speaker system. At this price point, nothing else comes close.",
                'features' => ['C. Bechstein Action', 'Natural Grand Hammer Action', '6-Speaker System', 'Three Grand Piano Voices'],
                'includes' => ['Integrated Stand', 'Three Pedals', 'Bench'],
                'dimensions' => ['height' => '38"', 'width' => '56"', 'depth' => '19"', 'weight' => '172 lbs'],
                'serial_number' => 'CGP510-3345621',
            ],
            [
                'brand' => 'Roland', 'category' => 'Digital Piano',
                'name' => 'Roland HP-704 Digital Piano', 'year' => 2021,
                'condition' => 'very_good', 'finish' => 'Charcoal Black',
                'sale_price' => 200000, 'rental_price_monthly' => 5000, 'rental_deposit' => 10000,
                'type' => 'rental',
                'short_description' => 'Premium home digital piano. PHA-50 hybrid keyboard with SuperNATURAL sound.',
                'description' => "The HP-704 is Roland's sweet spot for home musicians. The PHA-50 keyboard blends wood and molded materials for a natural, consistent feel. Four-speaker system delivers clear, dynamic sound.\n\nPerfect rental piano for students — durable, low maintenance, and sounds great through headphones for quiet practice.",
                'features' => ['PHA-50 Keyboard', 'SuperNATURAL Piano', '4-Speaker System', 'Bluetooth'],
                'includes' => ['Integrated Stand', 'Three Pedals', 'Bench'],
                'dimensions' => ['height' => '43"', 'width' => '54"', 'depth' => '17"', 'weight' => '132 lbs'],
                'serial_number' => 'RHP704-2213456',
            ],

            // Hybrid Pianos
            [
                'brand' => 'Yamaha', 'category' => 'Hybrid Piano',
                'name' => 'Yamaha NU1XA AvantGrand Hybrid', 'year' => 2023,
                'condition' => 'excellent', 'finish' => 'Polished Ebony',
                'sale_price' => 550000, 'rental_price_monthly' => 11000, 'rental_deposit' => 22000,
                'type' => 'both', 'is_featured' => true,
                'short_description' => 'Real upright piano action meets Yamaha CFX sampling. The future of piano.',
                'description' => "The NU1XA puts a real acoustic upright piano action — with real wooden keys, real hammers, and real dampers — into a digital sound engine. You feel a real piano under your fingers, but hear Yamaha's CFX concert grand through premium speakers.\n\nZero maintenance, silent practice via headphones, never needs tuning. The upright form factor fits anywhere. This is what hybrid piano technology was always meant to be.",
                'features' => ['Real Acoustic Action', 'CFX Premium Grand Voice', 'Spatial Acoustic Speaker System', 'Binaural Sampling', 'USB Audio Recording'],
                'includes' => ['Integrated Stand', 'Three Pedals', 'Bench'],
                'dimensions' => ['height' => '40"', 'width' => '57"', 'depth' => '18"', 'weight' => '231 lbs'],
                'serial_number' => 'YNU1XA-1120345',
            ],

            // More rental-focused inventory
            [
                'brand' => 'Yamaha', 'category' => 'Upright Piano',
                'name' => 'Yamaha B2 Student Upright', 'year' => 2019,
                'condition' => 'good', 'finish' => 'Polished Ebony',
                'sale_price' => 480000, 'rental_price_monthly' => 10000, 'rental_deposit' => 20000,
                'type' => 'rental',
                'short_description' => 'Ideal student rental. Reliable Yamaha quality in a compact 45" frame.',
                'description' => "The Yamaha B2 is the perfect first piano for students. Compact enough for any room, yet tall enough (45 inches) to produce a full, satisfying tone. Yamaha's quality control ensures consistent key weight and action feel.\n\nOur most popular rental piano. Durable, reliable, and forgiving of the occasional missed note.",
                'features' => ['45" Compact Height', 'Spruce Soundboard', 'Soft-Close Fallboard'],
                'includes' => ['Bench'],
                'dimensions' => ['height' => '45"', 'width' => '58"', 'depth' => '22"', 'weight' => '466 lbs'],
                'serial_number' => 'YB2-3342189',
            ],
            [
                'brand' => 'Kawai', 'category' => 'Upright Piano',
                'name' => 'Kawai K-300 Upright', 'year' => 2021,
                'condition' => 'excellent', 'finish' => 'Ebony Satin',
                'sale_price' => 720000, 'rental_price_monthly' => 13000, 'rental_deposit' => 26000,
                'type' => 'rental',
                'short_description' => 'Professional 48" upright. ATX silent system available.',
                'description' => "The Kawai K-300 hits the sweet spot between the student K-200 and professional K-500. At 48 inches, it produces a noticeably fuller tone than compact uprights while remaining practical for home use.\n\nExcellent rental choice for intermediate to advanced students who need an instrument that won't hold them back.",
                'features' => ['Millennium III Action', 'NEOTEX Keytops', 'Duplex Scale', 'ATX Compatible'],
                'includes' => ['Matching Bench', 'First Tuning'],
                'dimensions' => ['height' => '48"', 'width' => '59"', 'depth' => '24"', 'weight' => '507 lbs'],
                'serial_number' => 'KK3-294571',
            ],

            // More sale items
            [
                'brand' => 'Steinway & Sons', 'category' => 'Grand Piano',
                'name' => 'Steinway Model B Music Room Grand', 'year' => 2010,
                'condition' => 'good', 'finish' => 'Ebony Satin',
                'sale_price' => 6900000, 'original_price' => 9200000,
                'type' => 'sale', 'is_certified' => true,
                'short_description' => 'The versatile 6\'10" grand. Equally at home in recital halls and living rooms.',
                'description' => "The Model B is often called the 'perfect piano' — large enough for serious performance, practical enough for a spacious home. At 6 feet 10 inches, it delivers nearly the tonal range of the Model D in a more manageable size.\n\nThis 2010 example has been Steinway-certified rebuilt with new hammers, strings, and dampers. The sound is commanding and the action is precise.",
                'features' => ['Steinway Certified Rebuild', 'New Hammers & Strings', 'Accelerated Action', 'Diaphragmatic Soundboard'],
                'includes' => ['Artist Bench', 'Piano Cover', 'First Tuning', 'Certificate of Rebuild'],
                'dimensions' => ['length' => '6\'10"', 'width' => '5\'0"', 'weight' => '760 lbs'],
                'serial_number' => 'SB-571823',
            ],
            [
                'brand' => 'Baldwin', 'category' => 'Baby Grand',
                'name' => 'Baldwin M1 Baby Grand', 'year' => 2000,
                'condition' => 'fair', 'finish' => 'Cherry Wood',
                'sale_price' => 180000, 'original_price' => 280000,
                'type' => 'sale',
                'short_description' => 'Affordable 5\'2" baby grand in warm cherry. Project piano with great bones.',
                'description' => "This Baldwin M1 needs some TLC but has excellent bones. The cherry wood cabinet has some surface scratches but the structure is sound. The soundboard is crack-free and the pin block is tight.\n\nIdeal for a DIY enthusiast or someone wanting a real grand piano at an entry-level price. Could also be a great candidate for our restoration services.",
                'features' => ['5\'2" Length', 'Cherry Cabinet', 'Sound Board in Good Condition'],
                'includes' => ['Bench'],
                'dimensions' => ['length' => '5\'2"', 'width' => '4\'10"', 'weight' => '525 lbs'],
                'serial_number' => 'BM1-723451',
            ],
            [
                'brand' => 'Yamaha', 'category' => 'Grand Piano',
                'name' => 'Yamaha C3X Conservatory Grand', 'year' => 2020,
                'condition' => 'excellent', 'finish' => 'Polished Ebony',
                'sale_price' => 4200000, 'rental_price_monthly' => 55000, 'rental_deposit' => 110000,
                'type' => 'both',
                'short_description' => 'The 6\'1" sweet spot. CX Series with exceptional dynamic range.',
                'description' => "The C3X is Yamaha's most popular size for serious musicians. At 6 feet 1 inch, it offers the tonal depth of a larger grand with a footprint that works in most rooms. The CX series redesign brought improved resonance and projection.\n\nThis instrument is in like-new condition. Perfect for advanced students, teachers, and performing artists.",
                'features' => ['CX Series', 'Ivorite Keytops', 'Duplex Scale', 'Slow-Close Fallboard'],
                'includes' => ['Matching Bench', 'Piano Cover', 'First Tuning'],
                'dimensions' => ['length' => '6\'1"', 'width' => '4\'11"', 'weight' => '710 lbs'],
                'serial_number' => 'YC3X-7891234',
            ],
        ];

        // Download piano images from Unsplash
        $photoUrls = $this->getPhotoUrls();

        foreach ($pianos as $i => $data) {
            $brand = $brands[$data['brand']];
            $category = $categories[$data['category']];

            $piano = Piano::create([
                'brand_id' => $brand->id,
                'category_id' => $category->id,
                'name' => $data['name'],
                'sku' => strtoupper(Str::substr($brand->slug, 0, 3)) . '-' . Str::slug(Str::substr($data['name'], 0, 10)) . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'description' => $data['description'],
                'short_description' => $data['short_description'],
                'year' => $data['year'],
                'condition' => $data['condition'],
                'finish' => $data['finish'],
                'dimensions' => $data['dimensions'] ?? null,
                'sale_price' => $data['sale_price'] ?? null,
                'original_price' => $data['original_price'] ?? null,
                'rental_price_monthly' => $data['rental_price_monthly'] ?? null,
                'rental_deposit' => $data['rental_deposit'] ?? $data['rental_price_monthly'] ?? null,
                'rental_minimum_months' => 3,
                'type' => $data['type'],
                'status' => 'available',
                'is_featured' => $data['is_featured'] ?? false,
                'is_certified' => $data['is_certified'] ?? false,
                'features' => $data['features'] ?? null,
                'includes' => $data['includes'] ?? null,
                'location' => 'Nashville Showroom',
                'serial_number' => $data['serial_number'] ?? null,
                'published_at' => now()->subDays(rand(1, 90)),
            ]);

            // Assign photos
            if (isset($photoUrls[$i])) {
                PianoPhoto::create([
                    'piano_id' => $piano->id,
                    'path' => $photoUrls[$i],
                    'filename' => basename($photoUrls[$i]),
                    'alt_text' => $data['name'],
                    'sort_order' => 0,
                    'is_primary' => true,
                ]);
            }
        }
    }

    private function getPhotoUrls(): array
    {
        // Use placeholder paths — real photos would be downloaded from Unsplash
        // during deployment. For local dev, these act as identifiers.
        $photos = [];
        $queries = [
            'steinway grand piano concert', 'yamaha grand piano', 'kawai grand piano',
            'baby grand piano living room', 'yamaha baby grand', 'bosendorfer piano',
            'upright piano studio', 'kawai upright piano', 'baldwin piano',
            'mason hamlin piano', 'roland digital piano', 'yamaha clavinova',
            'casio hybrid piano', 'roland home piano', 'yamaha hybrid piano',
            'student upright piano', 'kawai upright professional', 'steinway model b',
            'cherry wood piano', 'yamaha conservatory grand',
        ];

        // Try to fetch from Unsplash, fallback to placeholder paths
        try {
            $response = Http::timeout(10)->get('https://unsplash.com/napi/search/photos', [
                'query' => 'piano',
                'per_page' => 20,
            ]);

            if ($response->successful()) {
                $results = $response->json('results', []);
                foreach ($results as $i => $result) {
                    $url = $result['urls']['regular'] ?? $result['urls']['small'] ?? null;
                    if ($url) {
                        $filename = "piano-{$i}.jpg";
                        $path = "pianos/{$filename}";

                        // Download and store
                        $imageData = Http::timeout(15)->get($url . '&w=1200&q=80')->body();
                        if ($imageData) {
                            Storage::disk('public')->put($path, $imageData);
                            $photos[$i] = $path;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Unsplash unavailable — use placeholder paths
            $this->command?->warn('Could not fetch Unsplash photos: ' . $e->getMessage());
        }

        // Fill remaining with placeholder paths
        for ($i = count($photos); $i < 20; $i++) {
            $photos[$i] = "pianos/placeholder-{$i}.jpg";
        }

        return $photos;
    }
}
