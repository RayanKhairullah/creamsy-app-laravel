<?php

namespace App\Livewire\Cashier;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\TransactionItem;

class Receipt extends Component
{
    public $transaction;
    public $items;

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->items = TransactionItem::with('product')->where('transaction_id', $transaction->id)->get();
    }

    public function render()
    {
        return view('livewire.cashier.receipt');
    }
}
