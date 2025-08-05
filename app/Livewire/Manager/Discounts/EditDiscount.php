<?php

namespace App\Livewire\Manager\Discounts;

use Livewire\Component;
use App\Models\Discount;

class EditDiscount extends Component
{
    public $discount;
    public $name, $code, $type, $value, $minimum_purchase, $maximum_discount, $start_date, $end_date, $is_active, $description;

    public function mount(Discount $discount)
    {
        $this->discount = $discount;
        $this->name = $discount->name;
        $this->code = $discount->code;
        $this->type = $discount->type;
        $this->value = $discount->value;
        $this->minimum_purchase = $discount->minimum_purchase;
        $this->maximum_discount = $discount->maximum_discount;
        $this->start_date = $discount->start_date;
        $this->end_date = $discount->end_date;
        $this->is_active = $discount->is_active;
        $this->description = $discount->description;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $this->discount->update([
            'name' => $this->name,
            'code' => $this->code,
            'type' => $this->type,
            'value' => $this->value,
            'minimum_purchase' => $this->minimum_purchase,
            'maximum_discount' => $this->maximum_discount,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_active' => $this->is_active,
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
