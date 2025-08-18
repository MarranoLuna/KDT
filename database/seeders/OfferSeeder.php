<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $requests = array();

        for ($i = 1; $i<=20; $i++) {
            array_push($requests, ["request_id"=>$i]);
        }


        foreach ($requests as $oferta) {
            Offer::factory()->create($oferta);
        }
    }
}
