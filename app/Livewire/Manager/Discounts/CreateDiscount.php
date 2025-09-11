<?php

namespace App\Livewire\Manager\Discounts;

use Livewire\Component;
use App\Models\Discount;
use Illuminate\Support\Carbon;

class CreateDiscount extends Component
{
    public $name, $code, $type, $value, $minimum_purchase, $maximum_discount, $start_date, $end_date, $description;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:discounts,code',
            'type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $value = (float) $this->value;
        if ($this->type === 'percentage' && $value > 100) {
            $value = 100;
        }

        $discount = Discount::create([
            'name' => $this->name,
            'code' => $this->code,
            'type' => $this->type,
            'value' => $value,
            'minimum_purchase' => $this->minimum_purchase !== null ? (float) $this->minimum_purchase : 0,
            'maximum_discount' => $this->maximum_discount !== null ? (float) $this->maximum_discount : null,
            'start_date' => Carbon::parse($this->start_date)->startOfDay(),
            'end_date' => Carbon::parse($this->end_date)->endOfDay(),
            'description' => $this->description,
        ]);
        session()->flash('success', 'Discount created successfully!');
        return redirect()->route('manager.discounts.index');
    }

    public function render()
    {
        return view('livewire.manager.discounts.create-discount')
            ->layout('components.layouts.manager');
    }
}
