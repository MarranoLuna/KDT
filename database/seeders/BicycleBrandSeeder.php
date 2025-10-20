<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BicycleBrand;


class BicycleBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Venzo',
            'SPL',
            'Vairo',
            'Olmo',
        ];

        foreach ($brands as $brandName) {
            BicycleBrand::create([
                'name' => $brandName
            ]);
        }
    }
}