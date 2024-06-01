<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;
use App\Models\CarSpecification;

class OfferSeeder extends Seeder
{
    public function run()
    {
        // Najpierw usuń wszystkie specyfikacje samochodów
        CarSpecification::query()->delete();
        // Następnie usuń wszystkie oferty
        Offer::query()->delete();

        $offer1 = Offer::create([
            'car_model' => 'Mercedes-Benz Klasa S',
            'description' => 'Luksusowy samochód z najlepszymi osiągami.',
            'price' => 500000,
            'image' => 'offers/mercedes_benz_klasa_s.jpg',
        ]);

        CarSpecification::create([
            'offer_id' => $offer1->id,
            'engine' => 'V8 4.0L',
            'transmission' => 'Automatyczna',
            'color' => 'Czarny',
            'year' => 2021,
            'mileage' => 15000,
        ]);

        $offer2 = Offer::create([
            'car_model' => 'BMW X5',
            'description' => 'Wszechstronny SUV z nowoczesnymi technologiami.',
            'price' => 300000,
            'image' => 'offers/bmw_x5.jpg',
        ]);

        CarSpecification::create([
            'offer_id' => $offer2->id,
            'engine' => 'I6 3.0L',
            'transmission' => 'Automatyczna',
            'color' => 'Biały',
            'year' => 2020,
            'mileage' => 20000,
        ]);

        $offer3 = Offer::create([
            'car_model' => 'Audi Q7',
            'description' => 'Przestronny i komfortowy SUV dla całej rodziny.',
            'price' => 350000,
            'image' => 'offers/audi_q7.jpg',
        ]);

        CarSpecification::create([
            'offer_id' => $offer3->id,
            'engine' => 'V6 3.0L',
            'transmission' => 'Automatyczna',
            'color' => 'Srebrny',
            'year' => 2021,
            'mileage' => 10000,
        ]);

        $offer4 = Offer::create([
            'car_model' => 'Toyota Corolla',
            'description' => '2019 model, well-maintained, low mileage.',
            'price' => 45000,
            'image' => 'offers/toyota_corolla.jpg',
        ]);

        CarSpecification::create([
            'offer_id' => $offer4->id,
            'engine' => 'V8 4.0L',
            'transmission' => 'Automatyczna',
            'color' => 'Czarny',
            'year' => 2021,
            'mileage' => 15000,
        ]);

        $offer5 = Offer::create([
            'car_model' => 'Honda Civic',
            'description' => '2020 model, excellent condition, one owner.',
            'price' => 52000,
            'image' => 'offers/honda_civic.jpg',
            'discount' => 10,
        ]);

        CarSpecification::create([
            'offer_id' => $offer5->id,
            'engine' => 'I6 3.0L',
            'transmission' => 'Automatyczna',
            'color' => 'Biały',
            'year' => 2020,
            'mileage' => 20000,
        ]);

       
        $offer6 = Offer::create([
            'car_model' => 'Ford Mustang',
            'description' => 'Klasyczny amerykański muscle car.',
            'price' => 60000,
            'image' => 'offers/ford_mustang.jpg',
            'discount' => 10,
            'featured' => true, // Set as featured
        ]);

        CarSpecification::create([
            'offer_id' => $offer6->id,
            'engine' => 'V8 5.0L',
            'transmission' => 'Manualna',
            'color' => 'Czerwony',
            'year' => 2019,
            'mileage' => 25000,
        ]);
    }
}
