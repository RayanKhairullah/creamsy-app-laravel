<?php

namespace App\Livewire\Manager\Discounts;

use Livewire\Component;
use App\Models\Discount;

class CreateDiscount extends Component
{
    public $name, $code, $type, $value, $minimum_purchase, $maximum_discount, $start_date, $end_date, $is_active = true, $description;

    public function save()
    {
        $this->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        Discount::create([
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
        session()->flash('success', 'Discount created successfully!');
        return redirect()->route('manager.discounts.index');
    }

    public function render()
    {
        return view('livewire.manager.discounts.create-discount')
            ->layout('components.layouts.manager');
    }
}
