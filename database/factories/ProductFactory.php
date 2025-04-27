<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'product' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'images' => json_encode([$this->faker->imageUrl()]), // Armazena uma URL fictícia de imagem
            'id_confectionery' => \App\Models\Confectionery::factory(), // Supondo que você tenha uma fábrica para Confectionery
        ];
    }
}
