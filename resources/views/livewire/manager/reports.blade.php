<section class="w-full">
    <x-page-heading>
        <x-slot:title>Sales Report</x-slot:title>
        <x-slot:buttons>
            <button wire:click="exportXlsx" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                Download XLSX
            </button>
        </x-slot:buttons>
    </x-page-heading>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div class="bg-green-100 dark:bg-green-900 rounded-lg p-6">
            <div class="text-lg font-semibold mb-2">Total Sales</div>
            <div class="text-2xl font-bold">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
        </div>
        <div class="bg-blue-100 dark:bg-blue-900 rounded-lg p-6">
            <div class="text-lg font-semibold mb-2">Total Transactions</div>
            <div class="text-2xl font-bold">{{ $transactionCount }}</div>
        </div>
    </div>
</section>
