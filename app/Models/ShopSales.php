<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopSales extends Model
{
    use HasFactory;
    protected $fillable = [
        'sales_id', 'location_id', 'item_name', 'quantity',
    ];
}
