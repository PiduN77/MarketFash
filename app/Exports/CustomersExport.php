<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CustomersExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return Customer::query()->with('user');
    }

    public function headings(): array
    {
        return [
            'Customer ID',
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Gender',
            'Date of Birth',
            'Created At',
            'Updated At',
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->customer_id,
            $customer->FName,
            $customer->LName,
            $customer->email,
            $customer->phone,
            $customer->gender,
            $customer->date_of_birth,
            $customer->created_at->format('Y-m-d H:i:s'),
            $customer->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}