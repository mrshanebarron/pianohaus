<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Piano;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $pianos = Piano::where('type', '!=', 'rental')->get();

        $reviews = [
            ['rating' => 5, 'title' => 'Worth every penny', 'body' => "We searched for over a year before finding our Steinway at PianoHaus. The condition was exactly as described — actually better. The delivery team was careful and professional. Our piano teacher was stunned by the tone. This is a forever instrument."],
            ['rating' => 5, 'title' => 'Better than the showroom', 'body' => "Bought the Yamaha C7X sight unseen based on PianoHaus's detailed description and photos. When it arrived, I was floored. The action is incredibly even, the tone fills our entire living room. My only regret is not buying sooner."],
            ['rating' => 4, 'title' => 'Great piano, minor cosmetic wear', 'body' => "The Kawai GX-7 plays beautifully and the Millennium III action is everything they say it is. There were a couple of small scratches on the case not mentioned in the listing, but nothing that affects playability. PianoHaus offered a partial credit which was fair."],
            ['rating' => 5, 'title' => 'A dream in my living room', 'body' => "The Steinway Model M in mahogany is the most beautiful piece of furniture in our home. And it sounds incredible. My daughter practices without being asked now. That alone is worth the investment."],
            ['rating' => 4, 'title' => 'Excellent value for a grand', 'body' => "The Yamaha GB1K is perfect for our apartment. It's compact but has a surprisingly full sound. Not quite the depth of a larger grand, but at this price? Unbeatable. The team at PianoHaus made the whole process painless."],
            ['rating' => 5, 'title' => 'The Bösendorfer singing tone is real', 'body' => "I've played Steinways my entire career. The Bösendorfer 170 from PianoHaus opened my ears to something completely different. The warmth, the color — it sings where other pianos speak. Buying this instrument changed how I approach music."],
            ['rating' => 5, 'title' => 'Best upright I\'ve ever played', 'body' => "Upgraded from a cheap digital to the Yamaha U3 from PianoHaus. The difference is night and day. The touch, the resonance, the way it responds to dynamics — this is a real instrument. My teacher says my technique has improved dramatically since the switch."],
            ['rating' => 4, 'title' => 'Solid studio workhorse', 'body' => "The K-500 is my third Kawai and my favorite. The action is fast and responsive. I teach 30+ students a week on it and it holds up beautifully. The satin finish hides fingerprints which is a lifesaver with young students."],
            ['rating' => 3, 'title' => 'Good bones, needs some work', 'body' => "The Baldwin Hamilton plays well enough but the action felt a bit sluggish compared to my previous Yamaha. Had a technician regulate it and it's much better now. Fair price for what you get — just know what you're getting into with an older piano."],
            ['rating' => 5, 'title' => 'Mason & Hamlin lives up to the hype', 'body' => "The Model 50 has the most beautiful sustain of any upright I've played. The tension resonator really does something magical. Worth every cent."],
            ['rating' => 5, 'title' => 'Apartment-friendly perfection', 'body' => "The Roland LX-708 through headphones at midnight is transcendent. The hybrid wooden keys feel authentic. I can practice at 2 AM without disturbing anyone. The Bluetooth connectivity for recording is seamless."],
            ['rating' => 4, 'title' => 'Yamaha digital done right', 'body' => "The CLP-785 Clavinova sounds remarkably close to a real grand, especially the CFX voice. The key feel is the best I've experienced in a digital piano. If you can't have an acoustic, this is the next best thing."],
            ['rating' => 5, 'title' => 'Hybrid game-changer', 'body' => "The NU1XA is the answer to every pianist's apartment dilemma. Real action under your fingers, no tuning required, silent practice whenever you want. I actually prefer practicing on this over the Steinway at my school."],
            ['rating' => 4, 'title' => 'Surprisingly good for the price', 'body' => "The Casio GP-510 has a real Bechstein action and it shows. The key feel is miles ahead of any other digital at this price. Sound quality is good — not quite Yamaha or Roland flagship level, but the action alone is worth it."],
            ['rating' => 5, 'title' => 'Concert-quality in our music room', 'body' => "The Yamaha C3X has transformed our home. My wife and I both play, and this instrument responds to every nuance. The CX Series really does project better. We host small recitals now and guests can't believe the sound."],
            ['rating' => 5, 'title' => 'PianoHaus made it effortless', 'body' => "Not just a review of the piano — the entire PianoHaus experience was first-rate. They answered every question, the delivery was on time, and the first tuning was included. The Model B sounds magnificent in our recital room."],
            ['rating' => 4, 'title' => 'Perfect project piano', 'body' => "The Baldwin M1 needed exactly the work they described. I had it refinished and the hammers voiced — now it sounds beautiful. PianoHaus was honest about the condition and priced it fairly. A fun project for any piano enthusiast."],
            ['rating' => 5, 'title' => 'My students love it', 'body' => "I rent the HP-704 for my home studio. Students enjoy the variety of sounds and the built-in metronome. It's practically indestructible. Zero maintenance headaches compared to my old acoustic."],
            ['rating' => 5, 'title' => 'The right piano at the right time', 'body' => "Started my daughter on the B2 rental from PianoHaus. Six months in, she's hooked. The rental terms are fair and the piano arrived in perfect condition. We're already talking about upgrading to a grand."],
            ['rating' => 4, 'title' => 'Professional quality, fair price', 'body' => "The K-300 rental has been excellent for my practice needs. The Millennium III action keeps up with fast passages. Wish the deposit were a bit lower, but the quality of the instrument justifies it."],
        ];

        foreach ($reviews as $i => $data) {
            $customer = $customers[$i % $customers->count()];
            $piano = $pianos[$i % $pianos->count()];

            Review::create(array_merge($data, [
                'piano_id' => $piano->id,
                'customer_id' => $customer->id,
                'is_verified_purchase' => $i < 10,
                'is_approved' => $i < 17, // leave 3 pending for moderation demo
            ]));
        }
    }
}
