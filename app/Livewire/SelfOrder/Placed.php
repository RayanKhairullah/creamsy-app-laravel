<?php

namespace App\Livewire\SelfOrder;

use Livewire\Component;
use App\Models\Transaction;

class Placed extends Component
{
    public Transaction $transaction;

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function render()
    {
        return view('livewire.self-order.placed')->layout('components.layouts.app.frontend');
    }
}
