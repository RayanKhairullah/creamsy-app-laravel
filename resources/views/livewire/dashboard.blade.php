{{-- DEPRECATED: This dashboard is no longer used. --}}
<section class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Dashboard Bisnis Es Krim</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-green-100 to-green-300 dark:from-green-900 dark:to-green-700 rounded-xl p-6 shadow flex items-center gap-4">
            <div class="bg-green-600 text-white rounded-full p-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0-6C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/></svg>
            </div>
            <div>
                <div class="text-gray-600 text-sm font-semibold">Total Omzet</div>
                <div class="text-2xl font-bold text-green-700">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-100 to-blue-300 dark:from-blue-900 dark:to-blue-700 rounded-xl p-6 shadow flex items-center gap-4">
            <div class="bg-blue-600 text-white rounded-full p-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 10h18M9 6h6m-7 8h8m-4 4h.01"/></svg>
            </div>
            <div>
                <div class="text-gray-600 text-sm font-semibold">Total Transaksi</div>
                <div class="text-2xl font-bold text-blue-700">{{ $totalTransaksi }}</div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-yellow-100 to-yellow-300 dark:from-yellow-900 dark:to-yellow-700 rounded-xl p-6 shadow flex items-center gap-4">
            <div class="bg-yellow-500 text-white rounded-full p-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 17h16M4 13h16M4 9h16M4 5h16"/></svg>
            </div>
            <div>
                <div class="text-gray-600 text-sm font-semibold">Produk Terjual</div>
                <div class="text-2xl font-bold text-yellow-700">{{ $produkTerjual }}</div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-purple-100 to-purple-300 dark:from-purple-900 dark:to-purple-700 rounded-xl p-6 shadow flex items-center gap-4">
            <div class="bg-purple-600 text-white rounded-full p-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z"/></svg>
            </div>
            <div>
                <div class="text-gray-600 text-sm font-semibold">Produk Aktif</div>
                <div class="text-2xl font-bold text-purple-700">{{ $produkAktif }}</div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-pink-100 to-pink-300 dark:from-pink-900 dark:to-pink-700 rounded-xl p-6 shadow flex items-center gap-4">
            <div class="bg-pink-600 text-white rounded-full p-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87m9-3.13a4 4 0 1 0-8 0 4 4 0 0 0 8 0z"/></svg>
            </div>
            <div>
                <div class="text-gray-600 text-sm font-semibold">Customer</div>
                <div class="text-2xl font-bold text-pink-700">{{ $totalCustomer }}</div>
            </div>
        </div>
    </div>
    <div class="text-gray-500 text-sm">Statistik di atas adalah rekap data bisnis es krim Anda.</div>
</section>
