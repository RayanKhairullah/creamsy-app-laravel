<section class="w-full bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 p-4 border rounded-xl">
    <x-page-heading class="mb-6">
        <x-slot:title>Transaction History</x-slot:title>
        <x-slot:description>View and manage your completed sales transactions</x-slot:description>
    </x-page-heading>
    
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl overflow-hidden transition-colors duration-200">
        <!-- Filters and Controls -->
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="relative flex-1 max-w-md">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search transactions..." 
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                    >
                </div>
                
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap">Show:</span>
                    <select 
                        wire:model.live="perPage" 
                        class="border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                    </select>
                    
                    <span class="text-sm text-gray-600 dark:text-gray-400 ml-1 whitespace-nowrap">
                        {{ $transactions->total() }} total
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Transactions Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Transaction</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 font-mono">
                                #{{ str_pad($trx->id, 6, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $trx->transaction_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                Rp {{ number_format($trx->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($trx->transaction_date)->format('M d, Y') }}
                                <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                    {{ \Carbon\Carbon::parse($trx->transaction_date)->format('H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $trx->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 
                                       ($trx->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : 
                                       'bg-gray-100 text-gray-800 dark:bg-gray-700/50 dark:text-gray-200') }}">
                                    {{ ucfirst($trx->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <a 
                                    href="{{ route('cashier.transactions.receipt', $trx) }}"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2z" />
                                    </svg>
                                    Receipt
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 dark:bg-gray-700/50 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <p class="text-lg font-medium text-gray-900 dark:text-gray-100">No transactions found</p>
                                    <p class="text-gray-500 dark:text-gray-400 mt-1">Your transaction history will appear here</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0 text-sm text-gray-700 dark:text-gray-300">
                    Showing <span class="font-medium">{{ $transactions->firstItem() }}</span> to 
                    <span class="font-medium">{{ $transactions->lastItem() }}</span> of 
                    <span class="font-medium">{{ $transactions->total() }}</span> transactions
                </div>
                <div class="flex justify-center sm:justify-end">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</section>