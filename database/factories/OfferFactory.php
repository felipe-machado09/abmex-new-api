<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::factory()->create();

        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'recurrency_setup' => fake()->randomElement(['none', 'weekly', 'monthly', 'quarterly', 'semiannually', 'annually', 'custom']),
            'pages_setup' => $this->faker->text(),
            'product_id' => $product->id,
        ];
    }
}
