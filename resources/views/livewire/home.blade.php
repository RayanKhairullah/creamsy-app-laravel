<div class="container mx-auto py-2 px-2 md:px-0">
    <!-- Hero Section -->
    <section class="relative overflow-hidden rounded-2xl mb-10">
        <div class="relative z-10 p-8 md:p-12 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-700 dark:via-indigo-700 dark:to-purple-700 rounded-2xl text-white">
            <div class="max-w-3xl">
                <h1 class="text-3xl md:text-5xl font-extrabold leading-tight drop-shadow-sm">Sweeten Your Day with Premium Ice Cream</h1>
                <p class="mt-3 md:mt-4 text-white/90 md:text-lg">Crafted with love. Topped with joy. Served your way. Scan the menu and order instantly.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('selforder.order') }}" class="inline-flex items-center gap-2 bg-white text-blue-700 font-semibold px-5 py-3 rounded-xl shadow hover:shadow-md hover:translate-y-[-1px] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.293 1.293a1 1 0 00-.293.707V17h14M7 13l1.5 8m8-8l-1.5 8M9 21h.01M15 21h.01"/></svg>
                        Order Now
                    </a>
                    <a href="#ice-cream" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/30 text-white font-semibold px-5 py-3 rounded-xl transition">
                        Browse Menu
                    </a>
                </div>
            </div>
            <div class="absolute right-0 top-0 -mr-24 -mt-24 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>
        </div>
    </section>

    <!-- Category Quick Links -->
    <div class="flex flex-wrap items-center gap-3 md:gap-4 mb-8">
        <a href="#ice-cream" class="px-4 py-2 rounded-full bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 hover:shadow">Ice Cream</a>
        <a href="#toppings" class="px-4 py-2 rounded-full bg-pink-50 text-pink-700 dark:bg-pink-900/30 dark:text-pink-300 hover:shadow">Toppings</a>
        <a href="#cones" class="px-4 py-2 rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 hover:shadow">Cones & Cups</a>
    </div>

    <!-- Ice Cream Section -->
    <h2 class="text-2xl font-bold mb-6 text-center md:text-left text-gray-900 dark:text-gray-100" id="ice-cream">Ice Cream</h2>
    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @foreach($icecreams as $product)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 flex flex-col items-center p-3 group border border-gray-200 dark:border-gray-700 relative">
                <span class="absolute top-3 left-3 text-[10px] font-bold px-2 py-0.5 rounded-full bg-gradient-to-r from-yellow-200 to-amber-300 text-amber-900 shadow">Best Seller</span>
                <div class="w-24 h-24 flex items-center justify-center mb-2 bg-gradient-to-br from-white to-zinc-100 dark:from-gray-700 dark:to-gray-600 rounded-full overflow-hidden ring-1 ring-gray-100 dark:ring-gray-700">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                             class="object-contain h-20 w-20 drop-shadow-md group-hover:scale-110 transition-transform duration-300" 
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
                <div class="mt-2 flex items-center gap-2">
                    <div class="text-lg font-extrabold text-green-600 dark:text-green-400">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">Fresh</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Toppings Section -->
    <h2 class="text-2xl font-bold mb-6 text-center md:text-left text-gray-900 dark:text-gray-100" id="toppings">Toppings</h2>
    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @foreach($toppings as $product)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 flex flex-col items-center p-3 group border border-gray-200 dark:border-gray-700">
                <div class="w-24 h-24 flex items-center justify-center mb-2 bg-gradient-to-br from-white to-zinc-100 dark:from-gray-700 dark:to-gray-600 rounded-full overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                            class="object-cover h-20 w-20 drop-shadow-md group-hover:scale-110 transition-transform duration-300" 
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
                <div class="mt-2 flex items-center gap-2">
                    <div class="text-lg font-extrabold text-green-600 dark:text-green-400">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-pink-50 text-pink-700 dark:bg-pink-900/30 dark:text-pink-300">Yummy</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Cones & Cups Section -->
    <h2 class="text-2xl font-bold mb-6 text-center md:text-left text-gray-900 dark:text-gray-100" id="cones">Cones & Cups</h2>
    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($cones as $product)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 flex flex-col items-center p-3 group border border-gray-200 dark:border-gray-700">
                <div class="w-24 h-24 flex items-center justify-center mb-2 bg-gradient-to-br from-white to-zinc-100 dark:from-gray-700 dark:to-gray-600 rounded-full overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                             class="object-contain h-20 w-20 drop-shadow-md group-hover:scale-110 transition-transform duration-300" 
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
                <div class="mt-2 flex items-center gap-2">
                    <div class="text-lg font-extrabold text-green-600 dark:text-green-400">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">Crunchy</span>
                </div>
            </div>
        @endforeach
    </div>
</div>