<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'brand' => $this->faker->word(),
            'category' => $this->faker->word(),
            'image' => $this->faker->imageUrl(),
            'sku' => $this->faker->uuid(),
            'description' => $this->faker->text(),
            'retail_price' => $this->faker->randomNumber(4),
            'wholesale_price' => $this->faker->randomNumber(4),
            'cost' => $this->faker->randomNumber(4),
            'is_active' => $this->faker->boolean(),
            'is_featured' => $this->faker->boolean(),
            'is_sale' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'product_collection_id' => ProductCollection::factory(),
        ];
    }
}
