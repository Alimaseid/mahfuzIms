<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'item_name',
        'qunatity',
        'amount',
        'tax',
        'total',
        'purchase_order_id',
    ];
}
