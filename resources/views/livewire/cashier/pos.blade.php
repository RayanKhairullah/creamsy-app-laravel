<section class="w-full">
    <x-page-heading>
        <x-slot:title>Point of Sale</x-slot:title>
    </x-page-heading>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h4 class="font-semibold mb-2">Product List</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                @foreach($products as $product)
                <div class="bg-white dark:bg-zinc-800 rounded shadow p-4 flex flex-col items-start">
                    <div class="font-bold">{{ $product->name }}</div>
                    <div class="text-sm">Category: {{ ucfirst($product->category) }}</div>
                    <div class="text-sm">Price: Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    <flux:button wire:click="addToCart({{ $product->id }})" icon="plus" size="sm" class="mt-2">
                        Add
                    </flux:button>
                </div>
                @endforeach
            </div>
        </div>
        <div>
            <h4 class="font-semibold mb-2">Cart</h4>
            <x-table>
                <x-slot:head>
                    <x-table.row>
                        <x-table.heading>Name</x-table.heading>
                        <x-table.heading>Qty</x-table.heading>
                        <x-table.heading>Price</x-table.heading>
                        <x-table.heading>Sub</x-table.heading>
                        <x-table.heading></x-table.heading>
                    </x-table.row>
                </x-slot:head>
                <x-slot:body>
                    @foreach($cart as $i => $item)
                        <x-table.row>
                            <x-table.cell>{{ $item['name'] }}</x-table.cell>
                            <x-table.cell>{{ $item['quantity'] }}</x-table.cell>
                            <x-table.cell>Rp {{ number_format($item['price'], 0, ',', '.') }}</x-table.cell>
                            <x-table.cell>Rp {{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}</x-table.cell>
                            <x-table.cell>
                                <flux:button wire:click="removeFromCart({{ $i }})" icon="trash" size="sm" variant="danger">
                                    Remove
                                </flux:button>
                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-slot:body>
            </x-table>
        </div>
    </div>
    <div class="mt-8 p-4 bg-white dark:bg-zinc-800 rounded shadow max-w-md mx-auto">
        <form wire:submit.prevent="processPayment" class="space-y-4">
            <div>
                <label class="block font-medium mb-1">Discount</label>
                <flux:select wire:model.live="selectedDiscount">
                    <flux:select.option value="">None</flux:select.option>
                    @foreach($discounts as $discount)
                        <flux:select.option value="{{ $discount->id }}">{{ $discount->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div class="flex justify-between">
                <span>Subtotal:</span>
                <span><b>Rp {{ number_format($subtotal, 0, ',', '.') }}</b></span>
            </div>
            <div class="flex justify-between">
                <span>Discount:</span>
                <span><b>Rp {{ number_format($discountAmount, 0, ',', '.') }}</b></span>
            </div>
            <div class="flex justify-between">
                <span>Total:</span>
                <span><b>Rp {{ number_format($total, 0, ',', '.') }}</b></span>
            </div>
            <div>
                <label class="block font-medium mb-1">Payment Method</label>
                <flux:select wire:model.live="selectedPayment" required>
                    <flux:select.option value="">Select</flux:select.option>
                    @foreach($paymentMethods as $method)
                        <flux:select.option value="{{ $method->id }}">{{ $method->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div>
                <flux:input wire:model.live="amountPaid" label="Amount Paid" type="number" min="{{ $total }}" required />
            </div>
            <div class="flex justify-between">
                <span>Change:</span>
                <span><b>Rp {{ number_format($change, 0, ',', '.') }}</b></span>
            </div>
            <div>
                <flux:button type="submit" icon="credit-card" variant="primary" :disabled="$total == 0 || !$amountPaid || !$selectedPayment">Pay</flux:button>
            </div>
        </form>
    </div>
</section>