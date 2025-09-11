<?php

namespace App\Livewire\Cashier;

use Livewire\Component;
use App\Models\Product;
use App\Models\Discount;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Pos extends Component
{
    use WithPagination, LivewireAlert;
    
    public $cart = [];

    public $discounts;
    public $paymentMethods;
    public $searchQuery = '';
    public $selectedDiscount = null;
    public $paymentMethod = null;
    public $paidAmount = 0;
    public $perPage = 12;
    
    protected $listeners = ['productSelected' => 'addToCart'];
    
    public function mount()
    {
        $this->loadData();
    }
    
    public function loadData()
    {

            
        $this->discounts = Discount::activeValid()->get();
            
        $this->paymentMethods = PaymentMethod::where('is_active', 1)->get();
    }
    
    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);
        
        if ($product->stock_quantity <= 0) {
            $this->alert('error', 'Product is out of stock!');
            return;
        }
        
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price
            ];
        }
        
        $this->calculateSubtotal($productId);
        $this->searchQuery = '';
        $this->resetPage();
        
        $this->dispatch('product-added', name: $product->name);
    }
    
    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
        $this->dispatch('product-removed');
    }
    
    public function updateQuantity($productId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeFromCart($productId);
            return;
        }
        
        $product = Product::findOrFail($productId);
        if ($quantity > $product->stock_quantity) {
            $this->alert('error', 'Not enough stock available!');
            return;
        }
        
        $this->cart[$productId]['quantity'] = $quantity;
        $this->calculateSubtotal($productId);
    }
    
    protected function calculateSubtotal($productId)
    {
        $this->cart[$productId]['subtotal'] = 
            $this->cart[$productId]['price'] * $this->cart[$productId]['quantity'];
    }
    
    public function applyDiscount($discountId = null)
    {
        if (empty($discountId)) {
            $this->selectedDiscount = null;
            return;
        }
        
        // If it's already a Discount model, use it directly
        if ($discountId instanceof \App\Models\Discount) {
            // Verify it's still valid (within date range only)
            $isValid = optional($discountId->start_date)->lte(now()) &&
                optional($discountId->end_date)->gte(now());
            $this->selectedDiscount = $isValid ? $discountId : null;
            return;
        }
        
        // If it's a numeric ID, find the discount
        if (is_numeric($discountId)) {
            $this->selectedDiscount = Discount::activeValid()->find($discountId);
            return;
        }
        
        // If it's a string that can be cast to int, try to find the discount
        if (is_string($discountId) && ctype_digit($discountId)) {
            $this->selectedDiscount = Discount::activeValid()->find((int)$discountId);
            return;
        }
        
        // If we get here, set to null to be safe
        $this->selectedDiscount = null;
    }
    
    public function getSubtotalProperty()
    {
        return array_sum(array_column($this->cart, 'subtotal'));
    }
    
    public function getDiscountAmountProperty()
    {
        if (!$this->selectedDiscount || !$this->selectedDiscount instanceof \App\Models\Discount) {
            return 0;
        }
        
        if ($this->subtotal <= $this->selectedDiscount->minimum_purchase) {
            return 0;
        }
        
        $discountAmount = 0;
        if ($this->selectedDiscount->type === 'percentage') {
            $discountAmount = $this->subtotal * ($this->selectedDiscount->value / 100);
            if (isset($this->selectedDiscount->maximum_discount) && $discountAmount > $this->selectedDiscount->maximum_discount) {
                $discountAmount = $this->selectedDiscount->maximum_discount;
            }
        } else {
            $discountAmount = $this->selectedDiscount->value;
        }
        
        return $discountAmount;
    }
    
    public function getTotalProperty()
    {
        return $this->subtotal - $this->discountAmount;
    }
    
    public function getChangeProperty()
    {
        return max(0, $this->paidAmount - $this->total);
    }
    
    public function processPayment()
    {
        // Re-validate selected discount just before processing
        if ($this->selectedDiscount instanceof \App\Models\Discount) {
            $fresh = Discount::activeValid()->find($this->selectedDiscount->id);
            $this->selectedDiscount = $fresh ?: null;
        }

        $this->validate([
            'paymentMethod' => 'required|exists:payment_methods,id',
            'paidAmount' => 'required|numeric|min:'.$this->total
        ]);
        
        // Create transaction
        $transaction = Transaction::create([
            'transaction_number' => 'TRX-' . now()->format('Ymd') . '-' . Str::random(6),
            'cashier_id' => auth()->id(),
            'subtotal' => $this->subtotal,
            'discount_amount' => $this->discountAmount,
            'total_amount' => $this->total,
            'payment_method' => $this->paymentMethod,
            'paid_amount' => $this->paidAmount,
            'change_amount' => $this->change,
            'status' => 'completed',
            'transaction_date' => now(),
        ]);
        
        // Create transaction items and update stock
        foreach ($this->cart as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'total_price' => $item['subtotal'],
            ]);
            
            // Update product stock
            $product = Product::find($item['id']);
            $product->decrement('stock_quantity', $item['quantity']);
        }
        
        // Generate receipt data
        $receiptData = [
            'transaction_number' => $transaction->transaction_number,
            'date' => $transaction->transaction_date->format('Y-m-d H:i:s'),
            'cashier' => auth()->user()->name,
            'items' => array_values($this->cart),
            'subtotal' => $this->subtotal,
            'discount' => [
                'name' => $this->selectedDiscount ? $this->selectedDiscount->name : null,
                'amount' => $this->discountAmount
            ],
            'total' => $this->total,
            'payment' => [
                'method' => PaymentMethod::find($this->paymentMethod)->name,
                'amount' => $this->paidAmount,
                'change' => $this->change
            ]
        ];
        
        // Reset POS
        $this->resetCart();
        
        // Show success message and redirect to receipt
        $this->alert('success', 'Transaction completed successfully!');
        return redirect()->route('cashier.transactions.receipt', $transaction);
    }

    // Normalize paidAmount input like "10.000" or "10,000" to 10000
    public function updatedPaidAmount($value)
    {
        if (is_string($value)) {
            // Remove any non-digit characters
            $normalized = preg_replace('/[^\d]/', '', $value);
            $this->paidAmount = $normalized !== '' ? (int) $normalized : 0;
        }
    }

    // Quick action to set paid amount
    public function setPaidAmount($amount)
    {
        $this->paidAmount = (int) $amount;
    }
    
    public function resetCart()
    {
        $this->cart = [];
        $this->selectedDiscount = null;
        $this->paymentMethod = null;
        $this->paidAmount = 0;
        $this->searchQuery = '';
    }
    
    public function render()
    {
        $products = Product::where('is_active', 1)
            ->where('stock_quantity', '>', 0)
            ->when($this->searchQuery, function($query) {
                $query->where('name', 'like', '%'.$this->searchQuery.'%')
                      ->orWhere('category', 'like', '%'.$this->searchQuery.'%');
            })
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.cashier.pos', [
            'products' => $products,
            'subtotal' => $this->subtotal,
            'discountAmount' => $this->discountAmount,
            'total' => $this->total,
            'change' => $this->change
        ]);
    }
}