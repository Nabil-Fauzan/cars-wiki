<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Car::truncate();

        \App\Models\Car::create([
            'model_id' => 'PC-911-GTS',
            'make' => 'Porsche',
            'model' => '911 GT3 RS',
            'year' => 2023,
            'hp' => 518,
            'category' => 'Track Focused',
            'transmission' => 'PDK',
            'drivetrain' => 'RWD',
            'engine' => '4.0L Naturally Aspirated Flat-Six',
            'torque' => '342 LB-FT',
            'zero_to_sixty' => 3.0,
            'top_speed' => 184,
            'aerodynamics' => 0.39,
            'braking' => 92,
            'history' => 'The Porsche 911 GT3 RS (992) is the most extreme street-legal 911 ever produced, focusing entirely on aerodynamic efficiency and track performance.',
            'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDREoQHSGmo0GTdfpwKgoGyosT9sJRgysW0xfhJ33s6RGXnowgRZNhFFXAbmeZGTi50Mw3OuEH58AiMyxeuok4_IwOml8LQnwGGMOAd--bxf3gQWGKgBhhEHDa9_4Qz6xwdrpp32m3Ndmvt6G4-E3kiv4_Y8bAZeeynipcKn4BFg_NRqwICDW2Cg5tqrSV_h5pua5sSU4GEucfkZnyWkctXjEGXNeesiXyaWvOAv-oApQlrW2vSAxJ-zTwN71R3r16E3XLnB6hx8sFN',
            'pros' => ['Exceptional downforce', 'Instant throttle response', 'Precision handling'],
            'cons' => ['Aggressive ride', 'High maintenance', 'Minimal storage'],
            'status' => 'Live',
            'data_completion' => 95,
        ]);

        \App\Models\Car::create([
            'model_id' => 'FR-F8-TRIB',
            'make' => 'Ferrari',
            'model' => 'F8 Tributo',
            'year' => 2022,
            'hp' => 710,
            'category' => 'Supercar',
            'transmission' => '7-Speed Dual-Clutch',
            'drivetrain' => 'RWD',
            'engine' => '3.9L Twin-Turbo V8',
            'torque' => '568 LB-FT',
            'zero_to_sixty' => 2.9,
            'top_speed' => 211,
            'aerodynamics' => 0.31,
            'braking' => 98,
            'history' => 'The Ferrari F8 Tributo is a mid-engine sports car produced by the Italian automobile manufacturer Ferrari. The car is an update to the 488 with notable exterior and performance changes.',
            'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDs-_2qtTTWjKkLw9LnSZgP_Wlr5OIhImdBkcqYEQOP97Us2U44n1Av0uSCXDJnhbcpS1eqR_5_1gzeoHtZHLshOrXdYbsHVFgyp2JNIyE7snaBaoEsqd_cAtgJJAZp3JMKfnKsT5HuLh9slFBU-8Ddhvbp14jkuWQ0586RegEgBdzSrgHTDGmcIglC4wPcmspgLDcFaXITkG-JvWP5YcRcidx-T1AG6jIk-c03IwLQYZ9f2EBW4BNHkb3y9STccRBcKGmTsCPuK5Cm',
            'pros' => ['Incredible acceleration', 'Classic Ferrari sound', 'Beautiful design'],
            'cons' => ['High cost', 'Complex infotainment', 'Loud cabin'],
            'status' => 'Live',
            'data_completion' => 88,
        ]);

        \App\Models\Car::create([
            'model_id' => 'BM-M4-CSL',
            'make' => 'BMW M',
            'model' => 'M4 CSL',
            'year' => 2023,
            'hp' => 543,
            'category' => 'Coupé',
            'transmission' => '8-Speed Automatic',
            'drivetrain' => 'RWD',
            'engine' => '3.0L Twin-Turbo Inline-Six',
            'torque' => '479 LB-FT',
            'zero_to_sixty' => 3.6,
            'top_speed' => 191,
            'aerodynamics' => 0.34,
            'braking' => 104,
            'history' => 'The BMW M4 CSL is a limited-edition version of the M4 designed for maximum track performance, featuring significant weight reduction and increased power.',
            'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB4hg5PBQ8Rvsif3zXQTj0vBfZx8j533WRGgUvOX6yEJNj2fiac3VdN14M6VvwnGyfdUJpp9vGXMcXgByF3AyRqYM7KVh0k9BhqSULdPniWG8gYkenmTiu26v4elMuWog1Yga-oVR2YkDaNW5AqI5wPi9I-ZAG-KIUnNHdF-11iFOPQud7HLZ2Lp5yWTnWJt7q7C19TFB7-ptEwjN2cNwlewnJCW4BzdglcQRKnQmVygcjLKZaNuVs5qaBtve52mfNGoWx2JPJ2wJa0',
            'pros' => ['Raw power', 'Sharp steering', 'Exclusive'],
            'cons' => ['Stiff ride', 'Expensive for an M4', 'No rear seats'],
            'status' => 'Live',
            'data_completion' => 92,
        ]);
    }
}
