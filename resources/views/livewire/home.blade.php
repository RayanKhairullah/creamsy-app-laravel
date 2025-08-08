<div class="container mx-auto py-8 px-2 md:px-0">
    <!-- Ice Cream Section -->
    <h2 class="text-2xl font-bold mb-6 text-center md:text-left text-gray-900 dark:text-gray-100" id="ice-cream">Ice Cream</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
        @foreach($icecreams as $product)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex flex-col items-center p-3 group border border-gray-200 dark:border-gray-700">
                <div class="w-24 h-24 flex items-center justify-center mb-2 bg-gradient-to-br from-white to-zinc-100 dark:from-gray-700 dark:to-gray-600 rounded-full overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                             class="object-contain h-20 w-20 drop-shadow-md group-hover:scale-105 transition-transform duration-300" 
                             loading="lazy">
                    @else
                        <div class="h-20 w-20 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-full">
                            <span class="text-2xs text-gray-500 dark:text-gray-400">No Image</span>
                        </div>
                    @endif
                </div>
                <div class="font-semibold text-base text-gray-800 dark:text-gray-200 text-center">{{ $product->name }}</div>
                <div class="text-gray-600 dark:text-gray-400 text-xs text-center line-clamp-2 mt-1">
                    {{ $product->description }}
                </div>
                <div class="text-lg font-bold text-green-600 dark:text-green-400 mt-2">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
            </div>
        @endforeach
    </div>

    <!-- Toppings Section -->
    <h2 class="text-2xl font-bold mb-6 text-center md:text-left text-gray-900 dark:text-gray-100" id="toppings">Toppings</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
        @foreach($toppings as $product)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex flex-col items-center p-3 group border border-gray-200 dark:border-gray-700">
                <div class="w-24 h-24 flex items-center justify-center mb-2 bg-gradient-to-br from-white to-zinc-100 dark:from-gray-700 dark:to-gray-600 rounded-full overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                            class="object-cover h-20 w-20 drop-shadow-md group-hover:scale-105 transition-transform duration-300" 
                            loading="lazy">
                    @else
                        <div class="h-20 w-20 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-full">
                            <span class="text-2xs text-gray-500 dark:text-gray-400">No Image</span>
                        </div>
                    @endif
                </div>
                <div class="font-semibold text-base text-gray-800 dark:text-gray-200 text-center">{{ $product->name }}</div>
                <div class="text-gray-600 dark:text-gray-400 text-xs text-center line-clamp-2 mt-1">
                    {{ $product->description }}
                </div>
                <div class="text-lg font-bold text-green-600 dark:text-green-400 mt-2">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
            </div>
        @endforeach
    </div>

    <!-- Cones & Cups Section -->
    <h2 class="text-2xl font-bold mb-6 text-center md:text-left text-gray-900 dark:text-gray-100" id="cones">Cones & Cups</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($cones as $product)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex flex-col items-center p-3 group border border-gray-200 dark:border-gray-700">
                <div class="w-24 h-24 flex items-center justify-center mb-2 bg-gradient-to-br from-white to-zinc-100 dark:from-gray-700 dark:to-gray-600 rounded-full overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                             class="object-contain h-20 w-20 drop-shadow-md group-hover:scale-105 transition-transform duration-300" 
                             loading="lazy">
                    @else
                        <div class="h-20 w-20 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-full">
                            <span class="text-2xs text-gray-500 dark:text-gray-400">No Image</span>
                        </div>
                    @endif
                </div>
                <div class="font-semibold text-base text-gray-800 dark:text-gray-200 text-center">{{ $product->name }}</div>
                <div class="text-gray-600 dark:text-gray-400 text-xs text-center line-clamp-2 mt-1">
                    {{ $product->description }}
                </div>
                <div class="text-lg font-bold text-green-600 dark:text-green-400 mt-2">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
            </div>
        @endforeach
    </div>
</div>