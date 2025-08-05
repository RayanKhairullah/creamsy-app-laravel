<section class="w-full" id="receipt-area">
    <x-page-heading>
        <x-slot:title>Receipt</x-slot:title>
    </x-page-heading>
    <div class="mb-2">Transaction #: <b>{{ $transaction->transaction_number }}</b></div>
    <div class="mb-2">Date: <b>{{ $transaction->transaction_date }}</b></div>
    <div class="mb-2">Cashier: <b>{{ $transaction->cashier->name ?? '-' }}</b></div>
    <hr>
    <x-table>
        <x-slot:head>
            <x-table.row>
                <x-table.heading>Product</x-table.heading>
                <x-table.heading>Qty</x-table.heading>
                <x-table.heading>Price</x-table.heading>
                <x-table.heading>Sub</x-table.heading>
            </x-table.row>
        </x-slot:head>
        <x-slot:body>
            @foreach($items as $item)
                <x-table.row>
                    <x-table.cell>{{ $item->product->name }}</x-table.cell>
                    <x-table.cell>{{ $item->quantity }}</x-table.cell>
                    <x-table.cell>{{ number_format($item->unit_price, 0, ',', '.') }}</x-table.cell>
                    <x-table.cell>{{ number_format($item->total_price, 0, ',', '.') }}</x-table.cell>
                </x-table.row>
            @endforeach
        </x-slot:body>
    </x-table>
    <div class="mb-2">Subtotal: <b>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</b></div>
    <div class="mb-2">Discount: <b>Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</b></div>
    <div class="mb-2">Total: <b>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</b></div>
    <div class="mb-2">Paid: <b>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</b></div>
    <div class="mb-2">Change: <b>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</b></div>
    <flux:button class="mt-3" icon="printer" onclick="window.print()">Print</flux:button>
</section>
