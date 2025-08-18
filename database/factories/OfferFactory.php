<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price'=> fake()->boolean(70)? fake()->randomFloat(2,700,2000): fake()->randomFloat(2, 2000, 9000),
            'courier_id'=>fake()->numberBetween(1, 7),
            'request_id'=>fake()->numberBetween(1, 20),
        ];
    }
}
