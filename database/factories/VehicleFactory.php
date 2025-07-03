<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\VehicleType;
use App\Models\VehicleBrand;
use App\Models\Courier;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Vehicle::class;


    public function definition(): array
    {
        return [
            'model' => $this->faker->word(),
            'year' => $this->faker->year(),
            'color' => $this->faker->safeColorName(),
            'registration_plate' => strtoupper($this->faker->bothify('??###??')),
            'permission' => $this->faker->randomElement(['Nacional', 'Provincial']),
            'is_validated' => $this->faker->boolean(),
            'vehicle_type_id' => VehicleType::inRandomOrder()->first()->id,
            'vehicle_brand_id' => VehicleBrand::inRandomOrder()->first()->id,
            'courier_id' => Courier::inRandomOrder()->first()->id,
        ];

        

    }

    public function withFaker()
    {
        return \Faker\Factory::create('es_AR');
    }
    }
