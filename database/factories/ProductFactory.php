<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $user = User::factory()->create();
        $category = Category::factory()->create();

        return [
        'user_id' => $user->id,
        'category_id' =>  $category->id,
        'name' => fake()->name(),
        'description' => fake()->sentence(),
        'status' => fake()->randomElement(['active', 'inactive','blocked', 'sketch']),
        'available_sell' => fake()->boolean(),
        ];
    }
}