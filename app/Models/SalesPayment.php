<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'owner_id', 'location_id', 'customer_id', 'amount', 'payment_type', 'cheque_no', 'banck_receipt', 'status',
    ];
}
