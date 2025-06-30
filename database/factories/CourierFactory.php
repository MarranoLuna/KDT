<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courier>
 */
class CourierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dni_millones = fake()->numberBetween(20, 99);
        $dni_miles = fake()->numberBetween(101, 999);
        $dni_cienes = fake()->numberBetween(101, 999);
        $dni = "".$dni_millones.$dni_miles.$dni_cienes;

        return [
            'status' => fake()->boolean(),
            'start_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'dni' => $dni,
            'is_validated' => fake()->boolean(70),
            'balance'=> fake()->randomFloat(2,0,50000),
            'user_id'=>fake()->numberBetween(4, 10)
        ];
    }
}
