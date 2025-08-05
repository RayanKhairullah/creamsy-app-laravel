<section class="w-full">
    <x-page-heading>
        <x-slot:title>Edit Product</x-slot:title>
    </x-page-heading>
    <x-form wire:submit.prevent="update" class="space-y-6">
        <flux:input wire:model.live="name" label="Name" required />
        <flux:textarea wire:model.live="description" label="Description" />
        <flux:input wire:model.live="price" label="Price" type="number" required />
        <flux:select wire:model.live="category" label="Category" required>
            <flux:select.option value="">Select</flux:select.option>
            <flux:select.option value="ice_cream">Ice Cream</flux:select.option>
            <flux:select.option value="topping">Topping</flux:select.option>
            <flux:select.option value="cup">Cup</flux:select.option>
            <flux:select.option value="cone">Cone</flux:select.option>
        </flux:select>
        <flux:input wire:model.live="stock_quantity" label="Stock Quantity" type="number" required />

        <!-- Image Upload Section -->
        <div>
            <label for="new_image" class="block text-sm font-medium text-gray-700">Product Image (Optional)</label>
            <input type="file" wire:model="new_image" id="new_image" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
            @error('new_image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <div wire:loading wire:target="new_image" class="mt-2 text-sm text-gray-500">Uploading...</div>

            <div class="mt-4 flex space-x-4 items-start">
                @if ($existing_image && !$new_image)
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">Current Image:</p>
                        <img src="{{ asset('storage/' . $existing_image) }}" alt="{{ $name }}" class="h-24 w-24 object-cover rounded-md">
                    </div>
                @endif

                @if ($new_image)
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">New Image Preview:</p>
                        <img src="{{ $new_image->temporaryUrl() }}" class="h-24 w-24 object-cover rounded-md">
                    </div>
                @endif
            </div>
        </div>

        <flux:select wire:model.live="is_active" label="Status">
            <flux:select.option value="1">Active</flux:select.option>
            <flux:select.option value="0">Inactive</flux:select.option>
        </flux:select>
        <div class="flex gap-2">
            <flux:button type="submit" icon="save" variant="primary">Update</flux:button>
            <flux:button href="{{ route('manager.products.index') }}">Cancel</flux:button>
        </div>
    </x-form>
</section>
