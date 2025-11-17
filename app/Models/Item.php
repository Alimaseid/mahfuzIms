<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_name',
        'category',
        'quantity',
        'product_code',
        'unit',
        'other_unit',
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
        'reorder_for_shop',
        'shelf',
        'image2',

    ];
    public function shelf()
    {
        return $this->belongsTo(Shelf::class, 'shelves_id');
    }
    public function SalesOrderDetail()
    {
        return $this->hasMany(SalesOrderDetail::class, 'item_id');
    }

    // relationship with Inventory
    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'item_id');
    }
}
