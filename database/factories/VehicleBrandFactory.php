<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VehicleBrand>
 */
class VehicleBrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        
        'name' => $this->faker->randomElement([
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
        ]),
    ];

    }
}
