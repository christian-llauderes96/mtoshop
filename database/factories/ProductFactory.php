<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'price' => $this->faker->randomFloat(2, 5, 100), // Price between 5 and 100
            'stock_quantity' => $this->faker->numberBetween(1, 100),
            'category_id' => Category::inRandomOrder()->first()->id, // Random category
        ];
    }
}
