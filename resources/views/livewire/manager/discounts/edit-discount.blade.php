<section class="w-full">
    <x-page-heading>
        <x-slot:title>Edit Discount</x-slot:title>
    </x-page-heading>
    <x-form wire:submit.prevent="update" class="space-y-6">
        <flux:input wire:model.live="name" label="Name" required />
        <flux:input wire:model.live="code" label="Code" />
        <flux:select wire:model.live="type" label="Type" required>
            <flux:select.option value="">Select</flux:select.option>
            <flux:select.option value="percentage">Percentage</flux:select.option>
            <flux:select.option value="fixed_amount">Fixed Amount</flux:select.option>
        </flux:select>
        <flux:input wire:model.live="value" label="Value" type="number" required />
        <flux:input wire:model.live="minimum_purchase" label="Minimum Purchase" type="number" />
        <flux:input wire:model.live="maximum_discount" label="Maximum Discount" type="number" />
        <flux:input wire:model.live="start_date" label="Start Date" type="date" required />
        <flux:input wire:model.live="end_date" label="End Date" type="date" required />
        <div class="flex gap-2">
            <flux:button type="submit" icon="save" variant="primary">Update</flux:button>
            <flux:button href="{{ route('manager.discounts.index') }}">Cancel</flux:button>
        </div>
    </x-form>
</section>
