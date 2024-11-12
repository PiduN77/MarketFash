<x-filament-panels::page>
    <x-filament::section>
        {{ $this->form }}
    </x-filament::section>

    <x-filament::section>
        {{ $this->table }}
    </x-filament::section>

    @if($this->reportType === 'sales2')
        <x-filament::section>
            <div class="text-lg font-medium">
                Total Penjualan: Rp {{ number_format($this->getData()['totalSales'], 0, ',', '.') }}
            </div>
        </x-filament::section>
    @endif

    <x-filament::section>
        <div class="flex gap-4">
            <x-filament::button
                color="danger"
                tag="a"
                href="{{ $this->getData()['downloadUrlPdf'] }}"
            >
                Download PDF
            </x-filament::button>

            <x-filament::button
                color="success"
                tag="a"
                href="{{ $this->getData()['downloadUrlCsv'] }}"
            >
                Download CSV
            </x-filament::button>

            <x-filament::button
                color="info"
                tag="a"
                href="{{ $this->getData()['downloadUrlXlsx'] }}"
            >
                Download Excel
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-panels::page>