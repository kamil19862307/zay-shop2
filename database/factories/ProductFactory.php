<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
            'title' => ucfirst(fake()->name()),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'thumbnail' => $this->faker->fixturesImage('products', 'images/products'),
            'price' => fake()->numberBetween(100000, 10000000),
            'quantity' => fake()->numberBetween(0, 20),
            'on_home_page' => $this->faker->boolean(70),
            'sorting' => $this->faker->numberBetween(1, 999),
            'text' => $this->faker->realText(),
        ];
    }
}
