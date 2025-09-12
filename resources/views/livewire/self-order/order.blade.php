<section class="container mx-auto py-6 px-4">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Self Order</h1>
        <p class="text-gray-600 dark:text-gray-400">Browse menu, add to cart, place your order, and pay at the counter.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Products -->
        <section class="lg:col-span-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
                <div class="mb-4 flex items-center gap-3">
                    <div class="relative flex-1">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search products..." class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" />
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                    </div>
                </div>

                <!-- Ice Cream Section -->
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Ice Cream</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
                    @forelse($iceCream as $product)
                        <div wire:click="addToCart({{ $product->id }})" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-3 cursor-pointer hover:shadow transition">
                            <div class="relative pb-[100%] rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="absolute w-full h-full object-cover">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">No Image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="font-medium text-gray-900 dark:text-gray-100 truncate">{{ $product->name }}</span>
                                <span class="text-blue-600 dark:text-blue-400 font-bold text-sm">{{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No ice cream items.</p>
                    @endforelse
                </div>

                <!-- Topping Section -->
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Topping</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
                    @forelse($toppings as $product)
                        <div wire:click="addToCart({{ $product->id }})" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-3 cursor-pointer hover:shadow transition">
                            <div class="relative pb-[100%] rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="absolute w-full h-full object-cover">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">No Image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="font-medium text-gray-900 dark:text-gray-100 truncate">{{ $product->name }}</span>
                                <span class="text-blue-600 dark:text-blue-400 font-bold text-sm">{{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No toppings.</p>
                    @endforelse
                </div>

                <!-- Cup Section -->
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Cup</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @forelse($cups as $product)
                        <div wire:click="addToCart({{ $product->id }})" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-3 cursor-pointer hover:shadow transition">
                            <div class="relative pb-[100%] rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="absolute w-full h-full object-cover">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">No Image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="font-medium text-gray-900 dark:text-gray-100 truncate">{{ $product->name }}</span>
                                <span class="text-blue-600 dark:text-blue-400 font-bold text-sm">{{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No cups.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Cart -->
        <section class="lg:col-span-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Your Cart</h2>
                @error('cart')<p class="text-sm text-red-600 mb-2">{{ $message }}</p>@enderror
                @if(empty($cart))
                    <p class="text-gray-500 dark:text-gray-400">Cart is empty.</p>
                @else
                    <div class="space-y-3">
                        @foreach($cart as $item)
                            <div class="flex items-start justify-between border-b border-gray-200 dark:border-gray-700 pb-2">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $item['name'] }}</div>
                                    <div class="text-sm text-gray-500">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                                    <div class="mt-2 flex items-center gap-2">
                                        <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})" class="w-7 h-7 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">-</button>
                                        <span class="w-8 text-center">{{ $item['quantity'] }}</span>
                                        <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})" class="w-7 h-7 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">+</button>
                                        <button wire:click="removeFromCart({{ $item['id'] }})" class="ml-2 text-red-600 hover:underline text-sm">Remove</button>
                                    </div>
                                </div>
                                <div class="font-semibold text-blue-600 dark:text-blue-400">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Discount Code</label>
                        <div class="flex gap-2">
                            <input type="text" wire:model.defer="discountCode" class="flex-1 border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" placeholder="Enter code" />
                            <button type="button" wire:click="applyDiscountByCode" class="px-3 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">Apply</button>
                        </div>
                        @error('discountCode')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-4 space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-gray-900 dark:text-gray-100">Subtotal</span>
                            <span class="text-lg font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700 dark:text-gray-300">Discount</span>
                            <span class="font-semibold text-red-600">- Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between pt-2 border-t border-gray-200 dark:border-gray-700 mt-2">
                            <span class="font-bold text-gray-900 dark:text-gray-100">Total</span>
                            <span class="text-2xl font-extrabold text-blue-600 dark:text-blue-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endif

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Your Name (optional)</label>
                    <input type="text" wire:model.defer="customer_name" class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" placeholder="e.g. John" />
                </div>

                <button wire:click="placeOrder" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg disabled:opacity-60" @if(empty($cart)) disabled @endif>
                    Place Order (Pay at Counter)
                </button>
            </div>
        </section>
    </div>
</section>
