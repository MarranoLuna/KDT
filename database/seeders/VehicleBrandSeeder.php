<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VehicleBrand;


class VehicleBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Gilera',
            'Motomel',
            'Brava',
            'Honda',
            'Yamaha',
            'Zanella',
            'Suzuki',
            'Beta',
            'Corven',
            'Guerrero',
            'Mondial',
        ];

        foreach ($brands as $brandName) {
            VehicleBrand::create([
                'name' => $brandName
            ]);
        }
    }
}
