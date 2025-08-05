<section class="w-full">
    <x-page-heading>
        <x-slot:title>Transactions</x-slot:title>
    </x-page-heading>
    <div class="flex items-center justify-between w-full mb-6 gap-2">
        <flux:input wire:model.live="search" placeholder="Search transactions..." class="!w-auto" />
        <flux:spacer />
        <flux:select wire:model.live="perPage" class="!w-auto">
            <flux:select.option value="10">10 per page</flux:select.option>
            <flux:select.option value="25">25 per page</flux:select.option>
            <flux:select.option value="50">50 per page</flux:select.option>
        </flux:select>
    </div>
    <x-table>
        <x-slot:head>
            <x-table.row>
                <x-table.heading>ID</x-table.heading>
                <x-table.heading>Number</x-table.heading>
                <x-table.heading>Cashier</x-table.heading>
                <x-table.heading>Total</x-table.heading>
                <x-table.heading>Date</x-table.heading>
                <x-table.heading>Status</x-table.heading>
            </x-table.row>
        </x-slot:head>
        <x-slot:body>
            @foreach($transactions as $trx)
                <x-table.row>
                    <x-table.cell>{{ $trx->id }}</x-table.cell>
                    <x-table.cell>{{ $trx->transaction_number }}</x-table.cell>
                    <x-table.cell>{{ $trx->cashier->name ?? '-' }}</x-table.cell>
                    <x-table.cell>Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</x-table.cell>
                    <x-table.cell>{{ $trx->transaction_date }}</x-table.cell>
                    <x-table.cell>{{ ucfirst($trx->status) }}</x-table.cell>
                </x-table.row>
            @endforeach
        </x-slot:body>
    </x-table>
    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</section>
