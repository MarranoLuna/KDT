<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Address;
use App\Models\RequestStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Request>
 */
class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
     public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->sentence(),
            'payment_method' => $this->faker->randomElement(['', '', '']),
            'user_id' => User::inRandomOrder()->first()->id, 
            'origin_address_id' => Address::inRandomOrder()->first()->id, 
            'destination_address_id' => Address::inRandomOrder()->first()->id,
            'request_status_id' => RequestStatus::inRandomOrder()->first()->id,
        ];
    }
}
