<?php

namespace App\Livewire\Manager\Discounts;

use Livewire\Component;
use App\Models\Discount;
use Illuminate\Support\Carbon;

class EditDiscount extends Component
{
    public $discount;
    public $name, $code, $type, $value, $minimum_purchase, $maximum_discount, $start_date, $end_date, $description;

    public function mount(Discount $discount)
    {
        $this->discount = $discount;
        $this->name = $discount->name;
        $this->code = $discount->code;
        $this->type = $discount->type;
        $this->value = $discount->value;
        $this->minimum_purchase = $discount->minimum_purchase;
        $this->maximum_discount = $discount->maximum_discount;
        // Normalize to Y-m-d for <input type="date">
        $this->start_date = optional($discount->start_date)->format('Y-m-d');
        $this->end_date = optional($discount->end_date)->format('Y-m-d');
        $this->description = $discount->description;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:discounts,code,' . $this->discount->id,
            'type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Coerce types
        $value = (float) $this->value;
        $minPurchase = $this->minimum_purchase !== null ? (float) $this->minimum_purchase : 0;
        $maxDiscount = $this->maximum_discount !== null ? (float) $this->maximum_discount : null;
        $start = Carbon::parse($this->start_date)->startOfDay();
        $end = Carbon::parse($this->end_date)->endOfDay();

        // Additional guard: percentage should be within 0-100
        if ($this->type === 'percentage' && $value > 100) {
            $value = 100;
        }

        $this->discount->update([
            'name' => $this->name,
            'code' => $this->code,
            'type' => $this->type,
            'value' => $value,
            'minimum_purchase' => $minPurchase,
            'maximum_discount' => $maxDiscount,
            'start_date' => $start,
            'end_date' => $end,
            'description' => $this->description,
        ]);
        session()->flash('success', 'Discount updated successfully!');
        return redirect()->route('manager.discounts.index');
    }

    public function render()
    {
        return view('livewire.manager.discounts.edit-discount')
            ->layout('components.layouts.manager');
    }
}
