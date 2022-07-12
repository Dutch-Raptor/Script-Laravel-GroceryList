<?php

namespace Database\Factories;

use app\Models\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grocery>
 */
class GroceryFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        return [
            "name" => $this->faker->word,
            "price" => $this->faker->randomFloat(2, 0, 100),
            "quantity" => $this->faker->randomFloat(2, 0, 100),
            "purchased" => $this->faker->boolean,
            "category_id" => Category::inRandomOrder()->first()->id,
        ];
    }
}
