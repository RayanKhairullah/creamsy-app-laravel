<section class="container mx-auto py-6 px-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Admin Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400">Comprehensive overview of your business performance</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <flux:button 
                wire:click="filterByMonth"
                icon="calendar" 
                variant="outline" 
                class="text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/50"
                :active="$timeRange === 'month'"
            >
                This Month
            </flux:button>
            <flux:button 
                wire:click="filterAll"
                icon="bars-3" 
                variant="outline" 
                class="text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/50"
                :active="$timeRange === 'all'"
            >
                All Time
            </flux:button>
            <flux:button 
                wire:click="refreshData"
                wire:loading.attr="disabled"
                icon="arrow-path" 
                variant="outline" 
                class="text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50"
            >
                <span wire:loading.remove>Refresh</span>
                <span wire:loading>Refreshing...</span>
            </flux:button>
        </div>
    </div>
    
    <!-- Cards Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        <!-- Total Revenue Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700/50 p-5 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</p>
                    @if($timeRange === 'month')
                    <div class="flex items-center mt-2">
                        @php
                            $rev = round($revenueChange ?? 0);
                            $revenueChangeClass = $rev >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
                            $revenueIcon = $rev >= 0 ? 'M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V17a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z' : 'M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z';
                        @endphp
                        <span class="{{ $revenueChangeClass }} text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="{{ $revenueIcon }}" clip-rule="evenodd" />
                            </svg>
                            {{ abs($rev) }}% {{ $rev >= 0 ? 'increase' : 'decrease' }} from last month
                        </span>
                    </div>
                    @endif
                </div>
                <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Total Transactions Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700/50 p-5 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Transactions</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalTransaksi) }}</p>
                    @if($timeRange === 'month')
                    <div class="flex items-center mt-2">
                        @php
                            $trx = round($transactionChange ?? 0);
                            $transactionChangeClass = $trx >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
                        @endphp
                        <span class="{{ $transactionChangeClass }} text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V17a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            {{ abs($trx) }}% {{ $trx >= 0 ? 'increase' : 'decrease' }} from last month
                        </span>
                    </div>
                    @endif
                </div>
                <div class="bg-emerald-50 dark:bg-emerald-900/30 rounded-lg p-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M9 6h6m-7 8h8m-4 4h.01" />
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Products Sold Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700/50 p-5 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Products Sold</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($produkTerjual) }}</p>
                    @if($timeRange === 'month')
                    <div class="flex items-center mt-2">
                        @php
                            $prd = round($productsSoldChange ?? 0);
                            $productsSoldChangeClass = $prd >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
                        @endphp
                        <span class="{{ $productsSoldChangeClass }} text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V17a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            {{ abs($prd) }}% {{ $prd >= 0 ? 'increase' : 'decrease' }} from last month
                        </span>
                    </div>
                    @endif
                </div>
                <div class="bg-amber-50 dark:bg-amber-900/30 rounded-lg p-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Active Products Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700/50 p-5 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Active Products</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($produkAktif) }}</p>
                    <div class="flex items-center mt-2">
                        @php
                            $activeProductsChange = 0; // You can calculate this based on previous period
                            $activeProductsChangeClass = $activeProductsChange >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
                        @endphp
                        <span class="{{ $activeProductsChangeClass }} text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V17a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            {{ abs($activeProductsChange) }}% {{ $activeProductsChange >= 0 ? 'increase' : 'decrease' }} from last month
                        </span>
                    </div>
                </div>
                <div class="bg-purple-50 dark:bg-purple-900/30 rounded-lg p-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Customers Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700/50 p-5 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Customers</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalCustomer) }}</p>
                    <div class="flex items-center mt-2">
                        @php
                            $customersChange = 0; // You can calculate this based on previous period
                            $customersChangeClass = $customersChange >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
                        @endphp
                        <span class="{{ $customersChangeClass }} text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V17a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            {{ abs($customersChange) }}% {{ $customersChange >= 0 ? 'increase' : 'decrease' }} from last month
                        </span>
                    </div>
                </div>
                <div class="bg-cyan-50 dark:bg-cyan-900/30 rounded-lg p-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-600 dark:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87m9-3.13a4 4 0 1 0-8 0 4 4 0 0 0 8 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Transactions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700/50 p-5">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Transactions</h3>
            <flux:button 
                href="{{ route('manager.transactions.index') }}" 
                variant="outline" 
                class="text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50"
            >
                View All
            </flux:button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Transaction ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @for($i = 1; $i <= 5; $i++)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">TRX-2023080{{ $i }}-XXXX</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Customer {{ $i }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Aug {{ 15 - $i }}, 2023</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Rp {{ number_format(75000 * $i, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                    Completed
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <a href="#" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-6 text-gray-500 dark:text-gray-400 text-sm text-center">
        <p>Statistik di atas adalah rekap data bisnis es krim Anda. Data diperbarui secara real-time.</p>
    </div>
</section>