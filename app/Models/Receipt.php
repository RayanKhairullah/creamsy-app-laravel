<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 'receipt_number', 'receipt_data', 'printed_at', 'is_printed'
    ];

    protected $casts = [
        'receipt_data' => 'array',
        'printed_at' => 'datetime',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
