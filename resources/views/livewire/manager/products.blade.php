<section class="w-full">
    <x-page-heading>
        <x-slot:title>Products</x-slot:title>
        <x-slot:buttons>
            <flux:button href="{{ route('manager.products.create') }}" icon="plus" variant="primary">
                Add Product
            </flux:button>
        </x-slot:buttons>
    </x-page-heading>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex items-center justify-between w-full mb-6 gap-2">
        <flux:input wire:model.live="search" placeholder="Search products..." class="!w-auto" />
        <flux:spacer />
        <flux:select wire:model.live="perPage" class="!w-auto">
            <flux:select.option value="10">10 per page</flux:select.option>
            <flux:select.option value="25">25 per page</flux:select.option>
            <flux:select.option value="50">50 per page</flux:select.option>
        </flux:select>
    </div>
    <!-- Products Table -->
    <x-table>
        <x-slot:head>
            <x-table.row>
                <x-table.heading>Image</x-table.heading>
                <x-table.heading>Name</x-table.heading>
                <x-table.heading>Category</x-table.heading>
                <x-table.heading>Price</x-table.heading>
                <x-table.heading>Status</x-table.heading>
                <x-table.heading>Actions</x-table.heading>
            </x-table.row>
        </x-slot:head>
        <x-slot:body>
            @foreach($products as $product)
    <x-table.row>
        <x-table.cell>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-12 w-12 object-cover rounded-md">
            @else
                <div class="h-12 w-12 bg-gray-200 rounded-md flex items-center justify-center">
                    <span class="text-xs text-gray-500">No Image</span>
                </div>
            @endif
        </x-table.cell>
        <x-table.cell>{{ $product->name }}</x-table.cell>
        <x-table.cell>{{ $categories[$product->category] ?? ucfirst($product->category) }}</x-table.cell>
        <x-table.cell>Rp {{ number_format($product->price, 0, ',', '.') }}</x-table.cell>
        <x-table.cell>{{ $product->is_active ? 'Active' : 'Inactive' }}</x-table.cell>
        <x-table.cell class="flex gap-2">
            <flux:button href="{{ route('manager.products.edit', $product) }}" icon="pencil" size="sm">
                Edit
            </flux:button>
            <form wire:submit.prevent="delete({{ $product->id }})" onsubmit="return confirm('Are you sure you want to delete this product?');" style="display:inline;">
                <button type="submit" class="inline-flex items-center px-2 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Delete
                </button>
            </form>
        </x-table.cell>
    </x-table.row>
@endforeach
        </x-slot:body>
    </x-table>
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</section>