<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Offer;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //$id_requests_ofertadas = Offer::select('request_id')->distinct()->pluck('request_id');
        //$id_ofertas = Offer::whereIn('request_id', $id_requests_ofertadas)->pluck('id');
        $esta_completada = fake()->boolean(50);
            
        if($esta_completada){
            $status = 2;
        } else {
            $status = 1;
        }

        return [
            'order_status_id'=>$status,
            'offer_id'=>1,
            'is_completed'=>$esta_completada,
        ];
    }
}
