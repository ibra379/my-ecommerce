<?php

namespace Database\Factories;

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
            'name' => fake()->sentence,
            'description' => fake()->sentences(rand(1,3), true),
            'active' => fake()->boolean(80),
            'image' => fake()->imageUrl,
            'price' => rand(1000, 15000)
        ];
    }
}
