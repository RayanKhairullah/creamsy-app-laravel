<?php

namespace App\Livewire\Cashier;

use Livewire\Component;
use App\Models\Transaction;

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

    public function render()
    {
        $transactions = Transaction::where('cashier_id', auth()->id())
            ->when($this->search, function($query) {
                $query->where('id', 'like', '%'.$this->search.'%')
                      ->orWhere('transaction_number', 'like', '%'.$this->search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        return view('livewire.cashier.transactions', compact('transactions'));
    }
}
