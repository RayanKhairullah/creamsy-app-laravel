<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\User;

class Dashboard extends Component
{
    #[Layout('components.layouts.app')]
    public function render(): View
    {
        abort(404);
        $totalOmzet = Transaction::sum('total_amount');
        $totalTransaksi = Transaction::count();
        $produkTerjual = TransactionItem::sum('quantity');
        $produkAktif = Product::where('is_active', true)->count();
        // Handle if role 'customer' does not exist
        try {
            $totalCustomer = User::role('customer')->count();
        } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
            // Fallback: count users that are not admin/manager/cashier
            $totalCustomer = User::whereDoesntHave('roles', function($q) {
                $q->whereIn('name', ['admin', 'manager', 'cashier']);
            })->count();
        }

        return view('livewire.dashboard', [
            'totalOmzet' => $totalOmzet,
            'totalTransaksi' => $totalTransaksi,
            'produkTerjual' => $produkTerjual,
            'produkAktif' => $produkAktif,
            'totalCustomer' => $totalCustomer,
        ]);
    }
}

