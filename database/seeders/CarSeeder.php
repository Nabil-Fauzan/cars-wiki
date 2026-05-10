<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\Brand;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Car::truncate();
        Brand::truncate();
        \Illuminate\Support\Facades\DB::table('brand_car')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // Helper function to handle brand and car creation
        $seedCar = function ($data, $brandName) {
            $brand = Brand::firstOrCreate(['name' => $brandName]);
            $car = Car::create($data);
            $car->brands()->attach($brand->id);
        };

        $seedCar([
            'model_id' => 'PC-911-GTS',
            'model' => '911 GT3 RS',
            'year' => '2023',
            'hp' => ['518 hp'],
            'category' => 'Track Focused',
            'transmission' => 'PDK',
            'drivetrain' => 'RWD',
            'engine' => ['4.0L Naturally Aspirated Flat-Six'],
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
        ], 'Porsche');

        $seedCar([
            'model_id' => 'FR-F8-TRIB',
            'model' => 'F8 Tributo',
            'year' => '2022',
            'hp' => ['710 hp'],
            'category' => 'Supercar',
            'transmission' => '7-Speed Dual-Clutch',
            'drivetrain' => 'RWD',
            'engine' => ['3.9L Twin-Turbo V8'],
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
        ], 'Ferrari');

        $seedCar([
            'model_id' => 'BM-M4-CSL',
            'model' => 'M4 CSL',
            'year' => '2023',
            'hp' => ['543 hp'],
            'category' => 'Coupé',
            'transmission' => '8-Speed Automatic',
            'drivetrain' => 'RWD',
            'engine' => ['3.0L Twin-Turbo Inline-Six'],
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
        ], 'BMW');

        $seedCar([
            'model_id' => 'HD-NSX-NA2',
            'model' => 'NSX (NA2)',
            'year' => '2002',
            'hp' => ['290 hp'],
            'category' => 'Supercar',
            'transmission' => '6-Speed Manual',
            'drivetrain' => 'MR',
            'engine' => ['3.2L C32B V6 VTEC'],
            'torque' => '224 LB-FT',
            'zero_to_sixty' => 4.8,
            'top_speed' => 175,
            'aerodynamics' => 0.30,
            'braking' => 105,
            'history' => 'The NA2 NSX introduced the larger 3.2L engine and 6-speed transmission, further refining the "Everyday Supercar" formula.',
            'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c5/Acura_NSX_facelift_002.JPG/1200px-Acura_NSX_facelift_002.JPG',
            'pros' => ['Sublime handling', 'Exceptional visibility', 'VTEC sound'],
            'cons' => ['Limited luggage space', 'Expensive maintenance', 'Low torque'],
            'status' => 'Live',
            'data_completion' => 90,
        ], 'Honda');

        $seedCar([
            'model_id' => 'HD-NSX-NA1',
            'model' => 'NSX (NA1)',
            'year' => '1990',
            'hp' => ['270 hp'],
            'category' => 'Supercar',
            'transmission' => '5-Speed Manual',
            'drivetrain' => 'MR',
            'engine' => ['3.0L C30A V6 VTEC'],
            'torque' => '210 LB-FT',
            'zero_to_sixty' => 5.2,
            'top_speed' => 168,
            'aerodynamics' => 0.32,
            'braking' => 110,
            'history' => 'The original NA1 NSX changed the supercar world forever by proving that high performance could be reliable and user-friendly.',
            'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/e/e0/Honda_NSX_%28NA1%29_front.JPG',
            'pros' => ['Revolutionary ergonomics', 'All-aluminum body', 'Iconic pop-up lights'],
            'cons' => ['Interior feels dated', 'Tires wear quickly', 'Parts availability'],
            'status' => 'Live',
            'data_completion' => 88,
        ], 'Honda');

        $seedCar([
            'model_id' => 'PC-911-SC',
            'model' => '911 Sport Classic (992)',
            'year' => '2023',
            'hp' => ['542 hp'],
            'category' => 'Coupé',
            'transmission' => '7-Speed Manual',
            'drivetrain' => 'RWD',
            'engine' => ['3.7L Twin-Turbo Flat-Six'],
            'torque' => '442 LB-FT',
            'zero_to_sixty' => 3.9,
            'top_speed' => 196,
            'aerodynamics' => 0.33,
            'braking' => 98,
            'history' => 'The 992 Sport Classic combines the Turbo widebody with a manual transmission and the iconic ducktail spoiler, celebrating Porsches heritage.',
            'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/de/Porsche_992_Sport_Classic_IMG_6244.jpg/1200px-Porsche_992_Sport_Classic_IMG_6244.jpg',
            'pros' => ['Pure driving experience', 'Stunning design', 'Turbo power with RWD'],
            'cons' => ['Extremely expensive', 'Limited production', 'No PDK option'],
            'status' => 'Live',
            'data_completion' => 94,
        ], 'Porsche');

        $seedCar([
            'model_id' => 'TY-MR2-AW11',
            'model' => 'MR2 (AW11)',
            'year' => '1987',
            'hp' => ['145 hp'],
            'category' => 'Sport Compact',
            'transmission' => '5-Speed Manual',
            'drivetrain' => 'MR',
            'engine' => ['1.6L 4A-GZE Supercharged'],
            'torque' => '137 LB-FT',
            'zero_to_sixty' => 6.5,
            'top_speed' => 130,
            'aerodynamics' => 0.34,
            'braking' => 120,
            'history' => 'The first-generation MR2 brought mid-engine balance to the masses, especially in its rare supercharged trim.',
            'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/e/e0/Toyota_MR2_AW11_white.jpg',
            'pros' => ['Go-kart handling', 'Bulletproof reliability', 'Lightweight'],
            'cons' => ['Tiny cabin', 'Prone to rust', 'Difficult to work on'],
            'status' => 'Live',
            'data_completion' => 85,
        ], 'Toyota');

        $seedCar([
            'model_id' => 'MB-ECL-G1',
            'model' => 'Eclipse GSX (Gen 1)',
            'year' => '1991',
            'hp' => ['195 hp'],
            'category' => 'Sport Compact',
            'transmission' => '5-Speed Manual',
            'drivetrain' => 'AWD',
            'engine' => ['2.0L 4G63T Turbocharged'],
            'torque' => '203 LB-FT',
            'zero_to_sixty' => 6.8,
            'top_speed' => 143,
            'aerodynamics' => 0.35,
            'braking' => 115,
            'history' => 'The first-generation Eclipse GSX was a giant-killer in the early 90s, offering AWD and the legendary 4G63 engine.',
            'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/4/44/1991_Mitsubishi_Eclipse_GSX_front_left.jpg',
            'pros' => ['Highly tunable engine', 'All-weather traction', '90s pop-up style'],
            'cons' => ['Cheap interior plastics', 'Crankwalk concerns', 'Weighty AWD system'],
            'status' => 'Live',
            'data_completion' => 87,
        ], 'Mitsubishi');
    }
}
