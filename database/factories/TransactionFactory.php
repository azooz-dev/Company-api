<?php

namespace Database\Factories;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seller = Seller::has('products')->inRandomOrder()->first();
        $buyer  = User::whereNotIn('id', [$seller->id])->inRandomOrder()->first();
        $product = $seller->products()->inRandomOrder()->first();
        return [
            'quantity' => fake()->numberBetween(1, 3),
            'buyer_id' => $buyer->id,
            'product_id' => $product->id,
        ];
    }
}
