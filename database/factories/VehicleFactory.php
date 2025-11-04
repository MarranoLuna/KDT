<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\VehicleType;
use App\Models\MotorcycleBrand;
use App\Models\BicycleBrand;
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
        $vehicleType = VehicleType::inRandomOrder()->first();

        $brandData = [
        'motorcycle_brand_id' => null,
        'bicycle_brand_id' => null,
    ];
  
        if ($vehicleType->name === 'Motocicleta') {
            $brandData['motorcycle_brand_id'] = MotorcycleBrand::inRandomOrder()->first()->id;
            $brandData['bicycle_brand_id'] = null;
        } else if ($vehicleType->name === 'Bicicleta') {
            $brandData['motorcycle_brand_id'] = null;
            $brandData['bicycle_brand_id'] = BicycleBrand::inRandomOrder()->first()->id;
        }

        return [
            'model' => $this->faker->word(),
            'color' => $this->faker->safeColorName(),
            'registration_plate' => strtoupper($this->faker->bothify('??###??')),
            'is_validated' => $this->faker->boolean(),
            'vehicle_type_id' => $vehicleType->id,
            'motorcycle_brand_id' => $brandData['motorcycle_brand_id'],
            'bicycle_brand_id' => $brandData['bicycle_brand_id'],
            'courier_id' => Courier::inRandomOrder()->first()->id,
        ];

        

    }

    public function withFaker()
    {
        return \Faker\Factory::create('es_AR');
    }
    }
