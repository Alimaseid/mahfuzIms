<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodReceiving extends Model
{
    use HasFactory;
      protected $fillable = [
        'item_name',
        'category',
        'quantity',
        'product_code',
        'unit',
        'cost_price',
        'selling_price1',
        'selling_price2',
        'item_code',
        'part_number',
        'image',
        'brand',
        'bar_code',
        'status',
        'description',
        'reorder',
        'shelves_id',
        'image2',
        'invoice_no',
        'location_name',
        'receiving_date',

    ];
}
