<?php

namespace App\Livewire\Manager;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    protected $paginationTheme = 'tailwind'; // or 'bootstrap', depending on your UI

    protected $updatesQueryString = ['search', 'perPage'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        session()->flash('success', 'Product deleted successfully.');
    }

    public function render()
    {
        $products = Product::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('category', 'like', '%'.$this->search.'%');
            })
            ->orderByRaw("CASE 
                WHEN category = 'ice_cream' THEN 1 
                WHEN category = 'topping' THEN 2 
                WHEN category IN ('cone', 'cup') THEN 3 
                ELSE 4 
            END")
            ->orderBy('name')
            ->paginate($this->perPage);
            
        // Group products by category for the filter
        $categories = [
            'ice_cream' => 'Ice Cream',
            'topping' => 'Topping',
            'cone' => 'Cone & Cup', // Combined category
            'cup' => 'Cone & Cup'  // Both point to the same display name
        ];
        
        return view('livewire.manager.products', [
            'products' => $products,
            'categories' => $categories
        ])->layout('components.layouts.manager');
    }
}
