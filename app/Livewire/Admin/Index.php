<?php

namespace App\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\User;

class Index extends Component
{
    #[Layout('components.layouts.admin')]
    public function render(): View
    {
        $totalOmzet = Transaction::sum('total_amount');
        $totalTransaksi = Transaction::count();
        $produkTerjual = TransactionItem::sum('quantity');
        $produkAktif = Product::where('is_active', true)->count();
        try {
            $totalCustomer = User::role('customer')->count();
        } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
            $totalCustomer = User::whereDoesntHave('roles', function($q) {
                $q->whereIn('name', ['admin', 'manager', 'cashier']);
            })->count();
        }
        return view('livewire.admin.index', [
            'totalOmzet' => $totalOmzet,
            'totalTransaksi' => $totalTransaksi,
            'produkTerjual' => $produkTerjual,
            'produkAktif' => $produkAktif,
            'totalCustomer' => $totalCustomer,
        ]);
    }
}

