<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchsePayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'amount',
        'discount',
        'refrence_no',
        'payment_type',
        'BankName',
        'Docs',
        'Remarks',
        'owner_id',
        'vendor_id',
        'PL_id',
    ];
}
