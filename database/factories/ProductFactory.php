<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
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
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->paragraph(),
            'quantity' => $quantity = fake()->numberBetween(1, 10),
            'status' => $quantity == 0 ? Product::UNAVAILABLE_PRODUCT : Product::AVAILABLE_PRODUCT,
            'image' => fake()->randomElement(['1.png', '2.png', '3.png']),
            'seller_id' => User::all()->random()->id,
        ];
    }
}
