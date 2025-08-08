<?php

namespace App\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;
    
    public $startDate;
    public $endDate;
    public $timeRange = 'month'; // 'month' or 'all'

    public function mount()
    {
        $this->setDateRange();
    }

    protected function setDateRange()
    {
        if ($this->timeRange === 'month') {
            $this->startDate = now()->startOfMonth()->toDateString();
            $this->endDate = now()->endOfMonth()->toDateString();
        } else {
            $this->startDate = null;
            $this->endDate = null;
        }
    }

    public function filterByMonth()
    {
        $this->timeRange = 'month';
        $this->setDateRange();
    }

    public function refreshData()
    {
        // Just re-render the component with current filters
        $this->resetPage();
    }

    #[Layout('components.layouts.admin')]
    public function render(): View
    {
        $query = Transaction::query();
        
        // Apply date filter if dates are set
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ]);
        }

        // Get transaction data
        $totalOmzet = $query->sum('total_amount');
        $totalTransaksi = $query->count();
        
        // Get product data with the same date range
        $productQuery = TransactionItem::with('product');
        if ($this->startDate && $this->endDate) {
            $productQuery->whereHas('transaction', function($q) {
                $q->whereBetween('created_at', [
                    Carbon::parse($this->startDate)->startOfDay(),
                    Carbon::parse($this->endDate)->endOfDay()
                ]);
            });
        }
        
        // Get top selling products
        $topProducts = (clone $productQuery)
            ->selectRaw('product_id, SUM(quantity) as total_quantity, unit_price')
            ->groupBy('product_id', 'unit_price')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get()
            ->map(function($item) {
                return [
                    'name' => $item->product->name,
                    'quantity' => $item->total_quantity,
                    'revenue' => $item->total_quantity * $item->unit_price
                ];
            });
            
        // Get recent transactions
        $recentTransactions = Transaction::with('cashier')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($transaction) {
                return [
                    'id' => $transaction->id,
                    'invoice_number' => $transaction->transaction_number, // Using transaction_number instead of invoice_number
                    'customer' => $transaction->cashier?->name ?? 'Guest',
                    'total' => $transaction->total_amount,
                    'date' => $transaction->created_at->format('d M Y, H:i'),
                    'status' => $transaction->status
                ];
            });
        
        $produkTerjual = $productQuery->sum('quantity');
        $produkAktif = Product::where('is_active', true)->count();
        
        try {
            $totalCustomer = User::role('customer')
                ->when($this->startDate && $this->endDate, function($q) {
                    $q->whereBetween('created_at', [
                        Carbon::parse($this->startDate)->startOfDay(),
                        Carbon::parse($this->endDate)->endOfDay()
                    ]);
                })
                ->count();
        } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
            $totalCustomer = User::whereDoesntHave('roles', function($q) {
                $q->whereIn('name', ['admin', 'manager', 'cashier']);
            })
            ->when($this->startDate && $this->endDate, function($q) {
                $q->whereBetween('created_at', [
                    Carbon::parse($this->startDate)->startOfDay(),
                    Carbon::parse($this->endDate)->endOfDay()
                ]);
            })
            ->count();
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

