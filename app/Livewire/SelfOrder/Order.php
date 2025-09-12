<?php

namespace App\Livewire\SelfOrder;

use Livewire\Component;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Str;
use App\Models\Discount;

class Order extends Component
{
    public $cart = [];
    public $search = '';
    public $customer_name = '';
    public $discountCode = '';
    public $selectedDiscount = null; // Discount model or null

    protected $rules = [
        'customer_name' => 'nullable|string|max:255',
        'discountCode' => 'nullable|string|max:255',
    ];

    public function addToCart($productId)
    {
        $product = Product::where('is_active', true)->where('stock_quantity', '>', 0)->findOrFail($productId);

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price,
            ];
        }
        $this->recalc($productId);
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
    }

    public function updateQuantity($productId, $quantity)
    {
        $quantity = (int) $quantity;
        if ($quantity <= 0) {
            $this->removeFromCart($productId);
            return;
        }
        $product = Product::findOrFail($productId);
        if ($quantity > $product->stock_quantity) {
            $quantity = $product->stock_quantity; // cap to available
        }
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] = $quantity;
            $this->recalc($productId);
        }
    }

    protected function recalc($productId)
    {
        $this->cart[$productId]['subtotal'] = $this->cart[$productId]['price'] * $this->cart[$productId]['quantity'];
    }

    public function getSubtotalProperty()
    {
        return array_sum(array_column($this->cart, 'subtotal'));
    }

    public function getDiscountAmountProperty()
    {
        if (!$this->selectedDiscount instanceof Discount) {
            return 0;
        }
        // minimum purchase check
        if ($this->subtotal <= ($this->selectedDiscount->minimum_purchase ?? 0)) {
            return 0;
        }
        $amount = 0;
        if ($this->selectedDiscount->type === 'percentage') {
            $amount = $this->subtotal * ((float)$this->selectedDiscount->value / 100);
            if (isset($this->selectedDiscount->maximum_discount) && $this->selectedDiscount->maximum_discount !== null) {
                $amount = min($amount, (float)$this->selectedDiscount->maximum_discount);
            }
        } else {
            $amount = (float)$this->selectedDiscount->value;
        }
        return max(0, $amount);
    }

    public function getTotalProperty()
    {
        return max(0, $this->subtotal - $this->discountAmount);
    }

    public function applyDiscountByCode()
    {
        $this->validateOnly('discountCode');
        $code = trim($this->discountCode);
        if ($code === '') {
            $this->selectedDiscount = null;
            return;
        }
        $discount = Discount::where('code', $code)->activeValid()->first();
        if (!$discount) {
            $this->selectedDiscount = null;
            $this->addError('discountCode', 'Kode diskon tidak ditemukan atau sudah tidak aktif.');
            return;
        }
        $this->resetErrorBag('discountCode');
        $this->selectedDiscount = $discount;
    }

    public function placeOrder()
    {
        $this->validate();
        if (empty($this->cart)) {
            $this->addError('cart', 'Your cart is empty.');
            return;
        }

        // Revalidate discount (date-valid) before placing order
        if ($this->selectedDiscount instanceof Discount) {
            $fresh = Discount::activeValid()->find($this->selectedDiscount->id);
            $this->selectedDiscount = $fresh ?: null;
        }

        // Create pending transaction (no stock decrement here; payment at counter)
        $trx = Transaction::create([
            'transaction_number' => 'SELF-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
            'cashier_id' => null,
            'subtotal' => $this->subtotal,
            'discount_amount' => $this->discountAmount,
            'total_amount' => $this->total,
            'payment_method' => null,
            'paid_amount' => 0,
            'change_amount' => 0,
            'status' => 'pending',
            'transaction_date' => now(),
            'notes' => $this->selectedDiscount ? ('DISCOUNT: ' . ($this->selectedDiscount->code ?? $this->selectedDiscount->name)) : null,
            'source' => 'self_order',
            'customer_name' => $this->customer_name ?: null,
            'table_code' => null,
        ]);

        foreach ($this->cart as $item) {
            TransactionItem::create([
                'transaction_id' => $trx->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'total_price' => $item['subtotal'],
            ]);
        }

        $this->cart = [];
        $this->customer_name = '';

        return redirect()->route('selforder.placed', $trx);
    }

    public function render()
    {
        // Load products by category sections (no pagination for simplicity)
        $baseQuery = Product::where('is_active', true)->where('stock_quantity', '>', 0);
        $search = $this->search;

        $iceCream = (clone $baseQuery)
            ->where('category', 'ice_cream')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('name', 'like', "%$search%")
                       ->orWhere('category', 'like', "%$search%");
                });
            })
            ->orderBy('name')
            ->get();

        $toppings = (clone $baseQuery)
            ->where('category', 'topping')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('name', 'like', "%$search%")
                       ->orWhere('category', 'like', "%$search%");
                });
            })
            ->orderBy('name')
            ->get();

        $cups = (clone $baseQuery)
            ->whereIn('category', ['cup', 'cone'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('name', 'like', "%$search%")
                       ->orWhere('category', 'like', "%$search%");
                });
            })
            ->orderBy('name')
            ->get();

        return view('livewire.self-order.order', [
            'iceCream' => $iceCream,
            'toppings' => $toppings,
            'cups' => $cups,
            'subtotal' => $this->subtotal,
            'discountAmount' => $this->discountAmount,
            'total' => $this->total,
        ])->layout('components.layouts.app.frontend');
    }
}
