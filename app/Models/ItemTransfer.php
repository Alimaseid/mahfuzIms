<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemTransfer extends Model
{
    use HasFactory;

    public $fillable = [
        'item_name', 'transfer_from', 'transfer_to', 'quantity', 'transfer_by', 'shipped_by',
    ];
}
