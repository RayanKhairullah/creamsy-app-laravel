<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'type', 'value', 'minimum_purchase', 'maximum_discount', 'start_date', 'end_date', 'is_active', 'description'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'float',
        'minimum_purchase' => 'float',
        'maximum_discount' => 'float',
    ];

    // Scope: valid date range (inclusive)
    public function scopeWithinDate($query)
    {
        return $query->whereDate('start_date', '<=', now())
                     ->whereDate('end_date', '>=', now());
    }

    // Convenience scope: active and within date
    public function scopeActiveValid($query)
    {
        // Treat 'active' purely based on date range per business rule
        return $query->withinDate();
    }
}
