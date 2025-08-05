<?php

namespace App\Livewire\Manager;

use Livewire\Component;
use App\Models\Discount;

use Illuminate\Support\Carbon;

class Discounts extends Component
{
    use \Livewire\WithPagination;

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

    public function mount()
    {
        $this->updateExpiredDiscounts();
    }

    public function updateExpiredDiscounts()
    {
        Discount::where('is_active', 1)
            ->whereDate('end_date', '<', Carbon::now())
            ->update(['is_active' => 0]);
    }

    public function delete($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();
        session()->flash('success', 'Discount deleted successfully.');
    }

    public function render()
    {
        $this->updateExpiredDiscounts();
        $discounts = Discount::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('code', 'like', '%'.$this->search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        return view('livewire.manager.discounts', compact('discounts'))
            ->layout('components.layouts.manager');
    }
}