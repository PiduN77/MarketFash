<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Exports\CustomersExport;
use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as EksporTo;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('unduhPdf')
                ->label('Export')
                ->action('exportXLSX')
                ->color('success'),
        ];
    }

    public function exportXLSX()
    {
        return Excel::download(new CustomersExport, 'Customer.xlsx', EksporTo::XLSX);
    }
}