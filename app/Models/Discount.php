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
}
