<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected  $fillable = [
        'vender',
        'reference_number',
        'shipment_reference',
        'business_location',
        'owner',
        'payment_terms',
        'status',
        'account_number',
        'expected_delivery_date',
        'total_payment',
    ];
}
