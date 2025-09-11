<section class="w-full">
    <x-page-heading>
        <x-slot:title>Add Discount</x-slot:title>
    </x-page-heading>
    <x-form wire:submit.prevent="save" class="space-y-8 bg-white p-8 rounded-lg shadow">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <flux:input wire:model.live="name" label="Name" required />
            <flux:input wire:model.live="code" label="Code" />
            <flux:select wire:model.live="type" label="Type" required>
                <flux:select.option value="">Select</flux:select.option>
                <flux:select.option value="percentage">Percentage</flux:select.option>
                <flux:select.option value="fixed_amount">Fixed Amount</flux:select.option>
            </flux:select>
            <div>
                <label class="block text-sm font-medium mb-1">Value <span class="text-red-500">*</span></label>
                <input type="number" wire:model="value" class="form-input w-full" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Minimum Purchase</label>
                <input type="number" wire:model="minimum_purchase" class="form-input w-full">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Maximum Discount</label>
                <input type="number" wire:model="maximum_discount" class="form-input w-full">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Start Date <span class="text-red-500">*</span></label>
                <input type="date" wire:model="start_date" class="form-input w-full" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">End Date <span class="text-red-500">*</span></label>
                <input type="date" wire:model="end_date" class="form-input w-full" required>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea wire:model="description" class="form-input w-full" rows="3"></textarea>
        </div>
        <div class="flex justify-end gap-3 pt-4">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('manager.discounts.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </x-form>
</section>
