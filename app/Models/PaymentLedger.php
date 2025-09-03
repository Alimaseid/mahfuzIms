<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'customer_id',
        'narration',
        'voucher_no',
        'voucher_type',
        'refrence_no',
        'debit',
        'credit',
        'running_balance',
    ];
}
