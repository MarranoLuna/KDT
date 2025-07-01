<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
           return [
            'street' => $this->faker->streetName(),
            'number' => $this->faker->buildingNumber(),
            'intersection' => $this->faker->streetName(),
            'floor' => $this->faker->randomElement(['1', '2', '3', '4', '5', '6', 'A', 'B', 'C']),
            'department' => strtoupper($this->faker->randomLetter() . $this->faker->randomDigit()),
            'user_id' =>fake()->numberBetween(11,23)
        ];

    }
    public function withFaker()
{
    return \Faker\Factory::create('es_AR');
}
}
