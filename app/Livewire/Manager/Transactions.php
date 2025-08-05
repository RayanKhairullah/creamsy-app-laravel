<?php

namespace App\Livewire\Manager;

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
        $transactions = Transaction::with('cashier')
            ->when($this->search, function($query) {
                $query->where('id', 'like', '%'.$this->search.'%')
                    ->orWhereHas('cashier', function($q) {
                        $q->where('name', 'like', '%'.$this->search.'%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        return view('livewire.manager.transactions', compact('transactions'))
            ->layout('components.layouts.manager');
    }
}
