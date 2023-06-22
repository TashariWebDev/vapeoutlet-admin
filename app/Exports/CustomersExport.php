<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersExport implements FromCollection, WithMapping, WithHeadings
{
    public function headings(): array
    {
        return [
            '#',
            'Customer',
            'Email',
            'Phone',
            'Company',
            'VAT #',
            'Date Registered',
            'Type',
            'Sales Person',
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->id,
            $customer->name,
            $customer->email,
            $customer->phone,
            $customer->company,
            $customer->vat_number,
            $customer->created_at,
            $customer->type(),
            $customer->salesPerson?->name,
        ];
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return Customer::all();
    }
}
