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

        $street = $this->faker->streetName();
        $number = $this->faker->buildingNumber();    


           return [
            'street' => $street, // Usamos la variable
            'number' => $number, // Usamos la variable
            
        
            'address' => "$street $number, Gualeguaychú, Entre Ríos", // <-- CAMBIO CLAVE
            
            'intersection' => $this->faker->streetName(),
            'floor' => $this->faker->randomElement(['1', '2', '3', 'A', 'B']),
            'department' => strtoupper($this->faker->randomLetter() . $this->faker->randomDigit()),
            'user_id' => fake()->numberBetween(1, 10),
            'lat' => $this->faker->latitude(-33.033, -32.988),
            'lng' => $this->faker->longitude(-58.553, -58.484),
        ];

    }
    public function withFaker()
{
    return \Faker\Factory::create('es_AR');
}
}
