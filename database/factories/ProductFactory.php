<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
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
            'name' => fake()->word,
            'brand_id' => function () {
                return Brand::inRandomOrder()->first()->id;
            },
            'category_id' => function () {
                return Category::inRandomOrder()->first()->id;
            },
            'price' => fake()->randomFloat(2, 0, 1000),
            'image' => 'default-image.png',
            'description' => fake()->paragraph,
            'quantity' => fake()->numberBetween(1, 100),
        ];
    }
}
