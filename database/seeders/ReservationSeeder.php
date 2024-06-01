<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        $users = User::whereIn('email', ['client@example.com', 'jan@example.com', 'konradprorok@gmail.com'])->get();
        $offers = Offer::all();

        $reservations = [
            [
                'user_email' => 'client@example.com',
                'car_model' => 'Toyota Corolla',
                'reserved_at' => Carbon::now()->subDays(10),
            ],
            [
                'user_email' => 'jan@example.com',
                'car_model' => 'Honda Civic',
                'reserved_at' => Carbon::now()->subDays(5),
            ],
            [
                'user_email' => 'konradprorok@gmail.com',
                'car_model' => 'Mercedes-Benz Klasa S',
                'reserved_at' => Carbon::now()->subDays(2),
            ],
        ];

        foreach ($reservations as $reservation) {
            $user = $users->where('email', $reservation['user_email'])->first();
            $offer = $offers->where('car_model', $reservation['car_model'])->first();

            if ($user && $offer) {
                Reservation::create([
                    'user_id' => $user->id,
                    'offer_id' => $offer->id,
                    'reserved_at' => $reservation['reserved_at'],
                ]);
            }
        }
    }
}
