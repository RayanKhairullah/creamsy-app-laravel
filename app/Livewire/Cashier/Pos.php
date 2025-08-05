<?php

namespace App\Livewire\Cashier;

use Livewire\Component;
use App\Models\Product;
use App\Models\Discount;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\PaymentMethod;
use Illuminate\Support\Str;

class Pos extends Component
{
    public $products = [], $cart = [], $discounts = [], $paymentMethods = [], $selectedDiscount = null, $selectedPayment = null;
    public $customerName, $amountPaid, $change, $subtotal, $total, $discountAmount;

    public function mount()
    {
        $this->products = Product::where('is_active', 1)->get();
        $this->discounts = Discount::where('is_active', 1)->get();
        $this->paymentMethods = PaymentMethod::where('is_active', 1)->get();
        $this->cart = [];
        $this->subtotal = 0;
        $this->total = 0;
        $this->discountAmount = 0;
    }

    public function addToCart($productId, $quantity = 1, $variations = [])
    {
        $product = Product::find($productId);
        if (!$product) return;
        $found = false;
        foreach ($this->cart as &$item) {
            if ($item['product_id'] === $productId && $item['variations'] == $variations) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $this->cart[] = [
                'product_id' => $productId,
                'name' => $product->name,
                'category' => $product->category,
                'price' => $product->price,
                'quantity' => $quantity,
                'variations' => $variations,
            ];
        }
        $this->calculateTotals();
    }

    public function removeFromCart($index)
    {
        array_splice($this->cart, $index, 1);
        $this->calculateTotals();
    }

    public function applyDiscount($discountId)
    {
        $discount = Discount::find($discountId);
        $this->selectedDiscount = $discount;
        $this->calculateTotals();
    }

    public function selectPayment($paymentId)
    {
        $this->selectedPayment = PaymentMethod::find($paymentId);
    }

    public function calculateTotals()
    {
        $this->subtotal = collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        $this->discountAmount = 0;
        // Ensure selectedDiscount is always a Discount object
        if ($this->selectedDiscount && is_string($this->selectedDiscount)) {
            $this->selectedDiscount = \App\Models\Discount::find($this->selectedDiscount);
        }
        if ($this->selectedDiscount) {
            if ($this->subtotal >= $this->selectedDiscount->minimum_purchase) {
                if ($this->selectedDiscount->type === 'percentage') {
                    $this->discountAmount = $this->subtotal * ($this->selectedDiscount->value / 100);
                    if ($this->selectedDiscount->maximum_discount) {
                        $this->discountAmount = min($this->discountAmount, $this->selectedDiscount->maximum_discount);
                    }
                } else {
                    $this->discountAmount = $this->selectedDiscount->value;
                }
            }
        }
        $this->total = max($this->subtotal - $this->discountAmount, 0);
    }

    public function processPayment()
    {
        $this->validate([
            'amountPaid' => 'required|numeric|min:' . $this->total,
            'selectedPayment' => 'required',
        ]);
        // Ensure selectedPayment is always a PaymentMethod object
        if ($this->selectedPayment && is_string($this->selectedPayment)) {
            $this->selectedPayment = \App\Models\PaymentMethod::find($this->selectedPayment);
        }
        $transaction = Transaction::create([
            'transaction_number' => strtoupper(Str::random(10)),
            'cashier_id' => auth()->id(),
            'subtotal' => $this->subtotal,
            'discount_amount' => $this->discountAmount,
            'total_amount' => $this->total,
            'payment_method' => $this->selectedPayment->code,
            'paid_amount' => $this->amountPaid,
            'change_amount' => $this->amountPaid - $this->total,
            'status' => 'completed',
            'transaction_date' => now(),
        ]);
        foreach ($this->cart as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'total_price' => $item['price'] * $item['quantity'],
                'variations' => json_encode($item['variations']),
            ]);
        }
        $this->change = $this->amountPaid - $this->total;
        session()->flash('success', 'Transaction successful!');
        return redirect()->route('cashier.transactions.index');
    }

    public function render()
    {
        return view('livewire.cashier.pos');
    }
}
