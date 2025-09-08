<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Offer;
use App\Models\Order;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $id_requests_ofertadas = Offer::select('request_id')->distinct()->pluck('request_id');

        foreach ($id_requests_ofertadas as $id_req) {

            $id_ofertas = Offer::where('request_id', $id_req)->pluck('id');

            Order::factory()->create(['offer_id' => $id_ofertas[0]]);
            
        }

    }
}
