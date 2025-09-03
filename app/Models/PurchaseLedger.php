<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseLedger extends Model
{
    use HasFactory;
    public $fillable = ['by', 'to', 'purchase_order_id', 'debit', 'credit', 'balance',];
}
