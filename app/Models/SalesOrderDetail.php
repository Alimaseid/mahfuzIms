<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesOrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'batch_id',
        'location_id',
        'owner_id',
        'item_name',
        'quantity',
        'remaining',
        'tax',
        'discount',
        'amount',
        'total',
        'with_holding',
        'sales_order_id',
    ];

    public function salesOrder(): BelongsTo
    {
        return  $this->belongsTo(SalesOrder::class);
    }

    public function item(): BelongsTo
    {
        return  $this->belongsTo(Item::class);
    }
    public function location(): BelongsTo
    {
        return  $this->belongsTo(BusinessLocation::class);
    }
    public function batch(): BelongsTo
    {
        return  $this->belongsTo(Batch::class);
    }
}
