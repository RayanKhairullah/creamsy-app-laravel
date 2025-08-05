<div class="container mx-auto py-8 px-2 md:px-0">
    <h2 class="text-2xl font-bold mb-4 text-center md:text-left">Ice Cream</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
        @foreach($icecreams as $product)
            <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 flex flex-col items-center p-4 group">
                <div class="w-28 h-28 flex items-center justify-center mb-3 bg-gradient-to-br from-white to-zinc-100 rounded-full overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-contain h-24 w-24 drop-shadow-lg group-hover:scale-105 transition-transform duration-300" loading="lazy">
                    @else
                        <div class="h-24 w-24 flex items-center justify-center bg-gray-100 rounded-full">
                            <span class="text-xs text-gray-400">No Image</span>
                        </div>
                    @endif
                </div>
                <div class="font-semibold text-lg text-gray-800 text-center">{{ $product->name }}</div>
                <div class="text-gray-500 text-sm text-center line-clamp-2">{{ $product->description }}</div>
                <div class="text-xl font-bold text-green-600 mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            </div>
        @endforeach
    </div>
    <h2 class="text-2xl font-bold mb-4 text-center md:text-left">Toppings</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
        @foreach($toppings as $product)
            <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 flex flex-col items-center p-4 group">
                <div class="w-28 h-28 flex items-center justify-center mb-3 bg-gradient-to-br from-white to-zinc-100 rounded-full overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-contain h-24 w-24 drop-shadow-lg group-hover:scale-105 transition-transform duration-300" loading="lazy">
                    @else
                        <div class="h-24 w-24 flex items-center justify-center bg-gray-100 rounded-full">
                            <span class="text-xs text-gray-400">No Image</span>
                        </div>
                    @endif
                </div>
                <div class="font-semibold text-lg text-gray-800 text-center">{{ $product->name }}</div>
                <div class="text-gray-500 text-sm text-center line-clamp-2">{{ $product->description }}</div>
                <div class="text-xl font-bold text-green-600 mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            </div>
        @endforeach
    </div>
    <h2 class="text-2xl font-bold mb-4 text-center md:text-left">Cone</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($cones as $product)
            <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 flex flex-col items-center p-4 group">
                <div class="w-28 h-28 flex items-center justify-center mb-3 bg-gradient-to-br from-white to-zinc-100 rounded-full overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-contain h-24 w-24 drop-shadow-lg group-hover:scale-105 transition-transform duration-300" loading="lazy">
                    @else
                        <div class="h-24 w-24 flex items-center justify-center bg-gray-100 rounded-full">
                            <span class="text-xs text-gray-400">No Image</span>
                        </div>
                    @endif
                </div>
                <div class="font-semibold text-lg text-gray-800 text-center">{{ $product->name }}</div>
                <div class="text-gray-500 text-sm text-center line-clamp-2">{{ $product->description }}</div>
                <div class="text-xl font-bold text-green-600 mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            </div>
        @endforeach
    </div>
</div>
