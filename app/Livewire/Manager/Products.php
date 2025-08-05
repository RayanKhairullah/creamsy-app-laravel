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
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        return view('livewire.manager.products', compact('products'))
            ->layout('components.layouts.manager');
    }
}
