<?php

namespace Database\Factories;

use App\Models\SalesChannel;
use App\Models\StockTake;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StockTakeFactory extends Factory
{
    protected $model = StockTake::class;

    public function definition(): array
    {
        return [
            'date' => Carbon::now(),

            'sales_channel_id' => SalesChannel::factory(),
        ];
    }
}
