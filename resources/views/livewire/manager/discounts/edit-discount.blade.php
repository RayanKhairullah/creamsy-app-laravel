<section class="w-full">
    <x-page-heading>
        <x-slot:title>Edit Discount</x-slot:title>
    </x-page-heading>
    <x-form wire:submit.prevent="update" class="space-y-6">
        <flux:input wire:model.live="name" label="Name" required />
        @error('name')<p class="text-xs text-red-600">{{ $message }}</p>@enderror

        <flux:input wire:model.live="code" label="Code" />
        @error('code')<p class="text-xs text-red-600">{{ $message }}</p>@enderror

        <flux:select wire:model.live="type" label="Type" required>
            <flux:select.option value="">Select</flux:select.option>
            <flux:select.option value="percentage">Percentage</flux:select.option>
            <flux:select.option value="fixed_amount">Fixed Amount</flux:select.option>
        </flux:select>
        @error('type')<p class="text-xs text-red-600">{{ $message }}</p>@enderror

        <flux:input wire:model.live="value" label="Value" type="number" step="0.01" min="0" required />
        @error('value')<p class="text-xs text-red-600">{{ $message }}</p>@enderror

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <flux:input wire:model.live="minimum_purchase" label="Minimum Purchase" type="number" step="0.01" min="0" />
                @error('minimum_purchase')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <flux:input wire:model.live="maximum_discount" label="Maximum Discount" type="number" step="0.01" min="0" />
                @error('maximum_discount')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <flux:input wire:model.live="start_date" label="Start Date" type="date" required />
                @error('start_date')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <flux:input wire:model.live="end_date" label="End Date" type="date" required />
                @error('end_date')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
            <textarea wire:model.live="description" rows="3" class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>
        <div class="flex gap-2">
            <flux:button type="submit" icon="save" variant="primary">Update</flux:button>
            <flux:button href="{{ route('manager.discounts.index') }}">Cancel</flux:button>
        </div>
    </x-form>
</section>
