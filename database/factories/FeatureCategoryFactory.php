<?php

namespace Database\Factories;

use App\Models\FeatureCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FeatureCategoryFactory extends Factory
{
    protected $model = FeatureCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->sentence(2),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
