<?php

namespace Database\Seeders;

use App\Models\MotorcycleBrand;
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
            MotorcycleBrandSeeder::class, 
            BicycleBrandSeeder::class,
            AddressSeeder::class,   
            RequestStatusesSeeder::class,   
            VehicleTypeSeeder::class,   
            RequestSeeder::class, 
            VehicleSeeder::class,   
            OfferSeeder::class, 
            OrderStatusSeeder::class,
            OrdersSeeder::class,
            //comentario
        ]);

    }
}
    