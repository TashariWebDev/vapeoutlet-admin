<?php

namespace App\Http\Resources;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Customer */
class CustomerResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'alt_phone' => $this->alt_phone,
            'company' => $this->company,
            'vat_number' => $this->vat_number,
            'is_wholesale' => $this->is_wholesale,
            'registered_company_name' => $this->registered_company_name,
            'addresses' => CustomerAddressesResource::collection($this->addresses),
        ];
    }
}
