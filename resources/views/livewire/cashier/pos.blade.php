<section class="w-full bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 p-4 border rounded-xl" id="pos-container">
    <x-page-heading class="mb-6">
        <x-slot:title>Point of Sale</x-slot:title>
        <x-slot:description>Process customer transactions with ease</x-slot:description>
    </x-page-heading>
    <div class="flex flex-col lg:flex-row gap-6 overflow-auto" style="min-height: calc(100vh - 120px);">
        <!-- Left panel - Products -->
        <section class="lg:w-2/5 flex flex-col" id="product-section">
            <section class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-5 mb-4 transition-colors duration-200">
                <x-page-heading class="mb-4">
                    <x-slot:title>Products</x-slot:title>
                </x-page-heading>
                <div class="mb-4">
                    <div class="relative">
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="searchQuery" 
                            placeholder="Search products..." 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                            autofocus
                        >
                        <div class="absolute left-3 top-3 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach($products as $product)
                        <div 
                            wire:click="addToCart({{ $product->id }})" 
                            class="bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition-all duration-200 cursor-pointer transform hover:-translate-y-0.5"
                        >
                            <div class="p-3">
                                @if($product->image)
                                    <div class="relative pb-[100%] rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="absolute w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-full h-24 bg-gray-100 dark:bg-gray-700 flex items-center justify-center rounded-lg">
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">No Image</span>
                                    </div>
                                @endif
                                <h3 class="font-medium mt-2 text-sm truncate" title="{{ $product->name }}">{{ $product->name }}</h3>
                                <div class="flex justify-between items-center mt-1">
                                    <p class="text-blue-600 dark:text-blue-400 font-bold text-sm">{{ number_format($product->price, 0, ',', '.') }}</p>
                                    <span class="text-xs bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-2 py-0.5 rounded-full">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </section>
        </section>
        <!-- Right panel - Cart & Payment -->
        <section class="lg:w-3/5 flex flex-col" id="cart-section">
            <!-- Cart section -->
            <section class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-5 mb-4 flex-1 overflow-y-auto transition-colors duration-200">
                <div class="flex justify-between items-center mb-4">
                    <x-page-heading>
                        <x-slot:title>Shopping Cart</x-slot:title>
                    </x-page-heading>
                    @if(!empty($cart))
                        <button wire:click="resetCart" class="text-sm text-red-500 hover:text-red-700 dark:hover:text-red-400 transition-colors">
                            Clear All
                        </button>
                    @endif
                </div>
                @if(empty($cart))
                    <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                        <div class="bg-gray-100 dark:bg-gray-700/50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <p class="font-medium">Your cart is empty</p>
                        <p class="text-sm mt-1">Start adding products by clicking on them</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($cart as $item)
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3 transition-all hover:bg-gray-100 dark:hover:bg-gray-700">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ $item['name'] }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ number_format($item['price'], 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-blue-600 dark:text-blue-400 font-bold">{{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                                </div>
                                <div class="flex items-center justify-between mt-2">
                                    <div class="flex items-center">
                                        <button 
                                            wire:click.stop="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})" 
                                            class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <span class="mx-2 w-8 text-center font-medium">{{ $item['quantity'] }}</span>
                                        <button 
                                            wire:click.stop="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})" 
                                            class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </button>
                                    </div>
                                    <button 
                                        wire:click.stop="removeFromCart({{ $item['id'] }})" 
                                        class="text-red-500 hover:text-red-700 dark:hover:text-red-400 transition-colors p-1"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
            <!-- Payment section -->
            <section class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-5 transition-colors duration-200" id="payment-section">
                <x-page-heading class="mb-4">
                    <x-slot:title>Payment Details</x-slot:title>
                </x-page-heading>
                <div class="grid grid-cols-1 gap-4">
                    <!-- Payment details -->
                    <section id="amount-section" class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subtotal</label>
                                <div class="text-lg font-bold text-right text-gray-900 dark:text-gray-100">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Discount</label>
                                <div class="text-lg font-bold text-right text-red-500">- Rp {{ number_format($discountAmount, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-lg text-gray-900 dark:text-gray-100">Total</span>
                                <span class="font-bold text-2xl text-blue-600 dark:text-blue-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Method</label>
                                <select 
                                    wire:model="paymentMethod" 
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="">Select method</option>
                                    @foreach($paymentMethods as $method)
                                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Paid Amount</label>
                                <input 
                                    type="number" 
                                    wire:model.debounce.500ms="paidAmount" 
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="0"
                                >
                            </div>
                        </div>
                        <!-- Discount section -->
                        <section id="discount-section" class="mt-2">
                            <h3 class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Discounts</h3>
                            <div class="space-y-2">
                                <select 
                                    wire:model.change="selectedDiscount" 
                                    wire:change="applyDiscount($event.target.value)"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="">No discount</option>
                                    @foreach($discounts as $discount)
                                        <option value="{{ $discount->id }}">
                                            {{ $discount->name }} ({{ $discount->type === 'percentage' ? $discount->value.'%' : 'Rp '.number_format($discount->value, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                                @if($selectedDiscount && is_object($selectedDiscount) && property_exists($selectedDiscount, 'description') && $selectedDiscount->description)
                                    <div class="mt-1 text-xs text-green-600 dark:text-green-400">
                                        {{ $selectedDiscount->description }}
                                    </div>
                                @endif
                            </div>
                        </section>
                        <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                            <span class="font-medium text-gray-900 dark:text-gray-100">Change</span>
                            <span class="font-bold text-2xl {{ $change > 0 ? 'text-green-600' : 'text-gray-500' }} dark:text-green-400">Rp {{ number_format($change, 0, ',', '.') }}</span>
                        </div>
                        <button 
                            wire:click="processPayment" 
                            wire:loading.attr="disabled"
                            class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-70 disabled:cursor-not-allowed disabled:hover:scale-100 shadow-md hover:shadow-lg"
                            @if(!$paymentMethod || $paidAmount < $total) disabled @endif
                        >
                            <div class="flex items-center justify-center">
                                <span wire:loading.remove wire:target="processPayment">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Complete Transaction
                                </span>
                                <span wire:loading wire:target="processPayment">
                                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Processing...
                                </span>
                            </div>
                        </button>
                    </section>
                </div>
            </section>
        </section>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            // Add subtle animation when product is added to cart
            Livewire.on('product-added', (event) => {
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-6 right-6 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg z-50 transform translate-y-2 opacity-0 transition-all duration-300';
                toast.innerHTML = `<div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>${event.name} added to cart</span>
                </div>`;
                document.body.appendChild(toast);
                requestAnimationFrame(() => {
                    toast.classList.remove('translate-y-2', 'opacity-0');
                });
                setTimeout(() => {
                    toast.classList.add('translate-y-2', 'opacity-0');
                    setTimeout(() => {
                        document.body.removeChild(toast);
                    }, 300);
                }, 2000);
            });
            // Add keyboard navigation support
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    @this.resetCart();
                }
            });
        });
    </script>
    @endpush
</section>