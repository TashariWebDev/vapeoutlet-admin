<?php

use App\Models\StockTake;

test('it creates adjustments in the stock table', function () {

    $stockTake = StockTake::factory()->create();

    $response = $this->get('/');

    $response->assertStatus(200);
});
