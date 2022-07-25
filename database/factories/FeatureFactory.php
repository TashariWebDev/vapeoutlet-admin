<?php

namespace Database\Factories;

use App\Models\Feature;
use App\Models\FeatureCategory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FeatureFactory extends Factory
{
    protected $model = Feature::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->sentence(2),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'product_id' => Product::factory(),
            'feature_category_id' => FeatureCategory::factory(),
        ];
    }
}
