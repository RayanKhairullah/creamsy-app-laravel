<?php

namespace App\Livewire;


use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Product;

class Home extends Component
{
    public $icecreams;
    public $toppings;
    public $cones;

    #[Layout('components.layouts.app')]
    public function render(): View
    {
        $this->icecreams = \App\Models\Product::where('category', 'ice_cream')->where('is_active', true)->get();
        $this->toppings = \App\Models\Product::where('category', 'topping')->where('is_active', true)->get();
        $this->cones = \App\Models\Product::where('category', 'cone')->where('is_active', true)->get();
        return view('livewire.home', [
            'icecreams' => $this->icecreams,
            'toppings' => $this->toppings,
            'cones' => $this->cones,
        ]);
    }
}
