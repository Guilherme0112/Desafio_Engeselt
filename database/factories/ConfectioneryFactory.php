<?php

namespace Database\Factories;

use App\Models\Confectionery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Confectionery>
 */
class ConfectioneryFactory extends Factory
{

    protected $model = Confectionery::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'confectionery' => $this->faker->company,
            'phone' => $this->faker->phoneNumber,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'cep' => $this->faker->postcode,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'neighborhood' => $this->faker->word,
            'road' => $this->faker->streetName,
            'number' => $this->faker->buildingNumber,
        ];
    }
}
