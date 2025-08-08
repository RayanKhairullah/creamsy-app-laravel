<div>
    <style>
        @media print {
            body * {
                visibility: hidden !important;
            }
            #receipt-area, #receipt-area * {
                visibility: visible !important;
            }
            #receipt-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100vw;
                max-width: 800px;
                margin: 0 auto;
                background: white !important;
                color: black !important;
                padding: 20px !important;
                box-shadow: none !important;
            }
            .no-print {
                display: none !important;
            }
            .dark-mode-only {
                display: none !important;
            }
            .light-mode-only {
                display: block !important;
            }
        }
        
        @page {
            size: A4;
            margin: 0;
        }
        
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            color: black;
        }
        
        @media (prefers-color-scheme: dark) {
            .receipt-container {
                background: #1f2937 !important;
                color: #f3f4f6 !important;
            }
            
            .receipt-container .print-only-dark {
                background: #111827 !important;
                color: #f3f4f6 !important;
            }
        }
        
        .print-only-dark {
            background: #f9fafb;
            color: #1f2937;
        }
    </style>
    
    <section class="w-full max-w-4xl mx-auto" id="receipt-area">
        <div class="receipt-container bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md dark:shadow-none p-6 print-only-dark">
            <!-- Business Header -->
            <div class="text-center mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-center mb-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Creamsy Logo" class="h-16 w-auto">
                </div>
                <h1 class="text-2xl font-bold text-white dark:text-white">RECEIPT</h1>
                <div class="mt-2">
                    <p class="font-semibold text-gray-500 dark:text-white">Creamsy</p>
                    <p class="text-sm text-gray-500 dark:text-gray-300">123 Main Street, Kota rafflesia</p>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Phone: (123) 456-7890 | Email: info@business.com</p>
                </div>  
            </div>
            
            <!-- Transaction Details -->
            <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                <div>
                    <div class="flex">
                        <span class="font-medium w-24 text-gray-700 dark:text-gray-300">Transaction:</span>
                        <span class="font-mono">{{ $transaction->transaction_number }}</span>
                    </div>
                    <div class="flex mt-1">
                        <span class="font-medium w-24 text-gray-700 dark:text-gray-300">Date:</span>
                        <span>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y H:i') }}</span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="flex justify-end">
                        <span class="font-medium w-24 text-gray-700 dark:text-gray-300">Cashier:</span>
                        <span>{{ $transaction->cashier->name ?? 'System' }}</span>
                    </div>
                    <div class="flex justify-end mt-1">
                        <span class="font-medium w-24 text-gray-700 dark:text-gray-300">Payment:</span>
                        <span>{{ $transaction->paymentMethod->name ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Items Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700">
                            <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                            <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Qty</th>
                            <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($items as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-300">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-300">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-right font-medium text-gray-900 dark:text-white">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Summary Section -->
            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                <div class="flex justify-between mb-2">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Subtotal</span>
                    <span class="font-medium">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                </div>
                
                @if($transaction->discount_amount > 0)
                <div class="flex justify-between mb-2 text-red-600 dark:text-red-400">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Discount</span>
                    <span>- Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</span>
                </div>
                @endif
                
                <div class="flex justify-between border-t border-gray-200 dark:border-gray-700 pt-3 mt-1">
                    <span class="font-bold text-lg text-gray-900 dark:text-white">Total</span>
                    <span class="font-bold text-lg">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                </div>
                
                <div class="flex justify-between mt-3">
                    <span class="text-gray-700 dark:text-gray-300">Paid</span>
                    <span>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
                </div>
                
                <div class="flex justify-between font-bold text-green-600 dark:text-green-400 mt-1">
                    <span>Change</span>
                    <span>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="mt-8 pt-4 border-t border-gray-200 dark:border-gray-700 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">Thank you for your purchase!</p>
                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">This is an electronic receipt</p>
                <div class="mt-4 flex justify-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                        {{ $transaction->transaction_number }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Print Button -->
        <div class="mt-6 no-print flex justify-center">
            <button 
                onclick="window.print()" 
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2z" />
                </svg>
                Print Receipt
            </button>
        </div>
    </section>
</div>