<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemReturn extends Model
{
    use HasFactory;
    protected $fillable = [
        'return_date', 'sales_order_id', 'customer_id', 'return_by', 'return_to', 'refunded_type', 'refunded_amount',
    ];
}
