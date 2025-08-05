<?php

namespace App\Livewire\Cashier;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('components.layouts.cashier')]
    public function render(): View
    {
        return view('livewire.cashier.index');
    }
}
