<section class="container mx-auto py-12 px-4 text-center">
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow p-8">
        <div class="mx-auto mb-4 w-16 h-16 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Order Placed</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Please proceed to the counter to make your payment.</p>

        <div class="mt-6 text-left bg-gray-50 dark:bg-gray-700/40 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-300">Order Number</span>
                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $transaction->transaction_number }}</span>
            </div>
            @if($transaction->customer_name)
            <div class="flex items-center justify-between mt-2">
                <span class="text-sm text-gray-600 dark:text-gray-300">Name</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $transaction->customer_name }}</span>
            </div>
            @endif
            <div class="flex items-center justify-between mt-2">
                <span class="text-sm text-gray-600 dark:text-gray-300">Total</span>
                <span class="text-blue-600 dark:text-blue-400 font-semibold">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex items-center justify-between mt-2">
                <span class="text-sm text-gray-600 dark:text-gray-300">Status</span>
                <span class="text-yellow-700 dark:text-yellow-300 font-medium">Pending Payment</span>
            </div>
        </div>

        <a href="{{ route('selforder.order') }}" class="mt-6 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Place Another Order</a>
    </div>
</section>
