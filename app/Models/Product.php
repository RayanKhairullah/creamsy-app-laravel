<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'category', 'image', 'is_active', 'stock_quantity'
    ];

    /**
     * Get the transaction items for the product.
     */
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    /**
     * Boot the model and set up model events.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            $product->transactionItems()->delete();
        });
    }
}