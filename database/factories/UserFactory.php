<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'email' => fake('es_AR')->unique()->safeEmail(),
            'firstname' => fake('es_AR')->firstname(),
            'lastname' => fake('es_AR')->lastname(),
            'password' => "1234",
            'birthday'=> fake()->dateTimeBetween('-40 years', '-17 years')->format('Y-m-d'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10), 
            'role_id' => 1, 
        ];


    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
