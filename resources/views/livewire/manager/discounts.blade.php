<section class="w-full">
    <x-page-heading>
        <x-slot:title>Discounts</x-slot:title>
        <x-slot:buttons>
            <flux:button href="{{ route('manager.discounts.create') }}" icon="plus" variant="primary">
                Add Discount
            </flux:button>
        </x-slot:buttons>
    </x-page-heading>
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <div class="flex items-center justify-between w-full mb-6 gap-2">
        <flux:input wire:model.live="search" placeholder="Search discounts..." class="!w-auto" />
        <flux:spacer />
        <flux:select wire:model.live="perPage" class="!w-auto">
            <flux:select.option value="10">10 per page</flux:select.option>
            <flux:select.option value="25">25 per page</flux:select.option>
            <flux:select.option value="50">50 per page</flux:select.option>
        </flux:select>
    </div>
    <x-table>
        <x-slot:head>
            <x-table.row>
                <x-table.heading>ID</x-table.heading>
                <x-table.heading>Name</x-table.heading>
                <x-table.heading>Type</x-table.heading>
                <x-table.heading>Value</x-table.heading>
                <x-table.heading>Status</x-table.heading>
                <x-table.heading>Actions</x-table.heading>
            </x-table.row>
        </x-slot:head>
        <x-slot:body>
            @foreach($discounts as $discount)
                <x-table.row>
                    <x-table.cell>{{ $discount->id }}</x-table.cell>
                    <x-table.cell>{{ $discount->name }}</x-table.cell>
                    <x-table.cell>{{ ucfirst($discount->type) }}</x-table.cell>
                    <x-table.cell>{{ $discount->type === 'percentage' ? $discount->value.'%' : 'Rp '.number_format($discount->value, 0, ',', '.') }}</x-table.cell>
                    <x-table.cell>
                        @php
                            $now = now();
                            $start = \Illuminate\Support\Carbon::parse($discount->start_date);
                            $end = \Illuminate\Support\Carbon::parse($discount->end_date);
                            if ($now->lt($start)) {
                                $statusLabel = 'Upcoming';
                                $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300';
                            } elseif ($now->between($start, $end)) {
                                $statusLabel = 'Active';
                                $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300';
                            } else {
                                $statusLabel = 'Expired';
                                $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-700/50 dark:text-gray-200';
                            }
                        @endphp
                        <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </x-table.cell>
                    <x-table.cell class="flex gap-2">
                        <flux:button href="{{ route('manager.discounts.edit', $discount) }}" icon="pencil" size="sm">
                            Edit
                        </flux:button>
                        <form wire:submit.prevent="delete({{ $discount->id }})" onsubmit="return confirm('Are you sure you want to delete this discount?');" style="display:inline;">
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
        {{ $discounts->links() }}
    </div>
</section>
