<?php

namespace App\Http\Resources;

use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CustomerAddress */
class CustomerAddressesResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'line_one' => $this->line_one,
            'line_two' => $this->line_two,
            'suburb' => $this->suburb,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,

            'customer' => new CustomerResource($this->whenLoaded('customer')),
        ];
    }
}
