<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number', 'cashier_id', 'subtotal', 'discount_amount', 'total_amount', 'payment_method', 'payment_method_id', 'paid_amount', 'change_amount', 'status', 'transaction_date', 'notes'
    ];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }
}
