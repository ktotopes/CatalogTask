<?php

namespace Database\Factories;

use App\Models\Product;
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
            'name' => $this->faker->name(),
            'description' => $this->faker->text(200),
            'category_id' => Category::query()->inRandomOrder()->first()?->id ?? Category::factory(),
            'price' => $this->faker->numberBetween(0,100),
            'width' => $this->faker->numberBetween(0,50),
            'length' => $this->faker->numberBetween(0,50),
            'the_weight' => $this->faker->numberBetween(0,200),
        ];
    }
}
