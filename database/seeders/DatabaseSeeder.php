<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class, 
            CouriersSeeder::class,
            VehicleBrandSeeder::class, 
            AddressSeeder::class,   
            RequestStatusesSeeder::class,   
            VehicleTypeSeeder::class,   
            RequestSeeder::class, 
            VehicleSeeder::class,   
            OfferSeeder::class, 
<<<<<<< Updated upstream
            //OrderSeeder::class
=======
            OrderStatusSeeder::class,
            OrdersSeeder::class,
>>>>>>> Stashed changes
            //comentario
        ]);

    }
}
