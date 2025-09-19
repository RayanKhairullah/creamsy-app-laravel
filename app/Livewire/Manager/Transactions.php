<?php

namespace App\Livewire\Manager;

use Livewire\Component;
use App\Models\Transaction;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesReportExport;
use App\Exports\TransactionsRangeExport;
use Illuminate\Support\Carbon;

use Livewire\WithPagination;

class Transactions extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    protected $paginationTheme = 'tailwind';
    protected $updatesQueryString = ['search', 'perPage'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function exportXlsx()
    {
        return Excel::download(new SalesReportExport, 'sales_report.xlsx');
    }

    public function exportDaily()
    {
        $from = Carbon::today()->startOfDay();
        $to = Carbon::today()->endOfDay();
        return Excel::download(new TransactionsRangeExport($from, $to, null), 'transactions_daily_'.now()->format('Ymd').'.xlsx');
    }

    public function exportWeekly()
    {
        $from = Carbon::now()->startOfWeek();
        $to = Carbon::now()->endOfWeek();
        return Excel::download(new TransactionsRangeExport($from, $to, null), 'transactions_weekly_'.now()->format('o-\WW').'.xlsx');
    }

    public function exportMonthly()
    {
        $from = Carbon::now()->startOfMonth();
        $to = Carbon::now()->endOfMonth();
        return Excel::download(new TransactionsRangeExport($from, $to, null), 'transactions_monthly_'.now()->format('Ym').'.xlsx');
    }

    public function render()
    {
        $transactions = Transaction::with('cashier')
            ->when($this->search, function($query) {
                $query->where('id', 'like', '%'.$this->search.'%')
                    ->orWhereHas('cashier', function($q) {
                        $q->where('name', 'like', '%'.$this->search.'%');
                    });
            })
            ->orderBy('transaction_date', 'desc')
            ->paginate($this->perPage);
        return view('livewire.manager.transactions', compact('transactions'))
            ->layout('components.layouts.manager');
    }
}
