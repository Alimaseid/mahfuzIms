<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodReceiving extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'batch_id',
        'receiving_date',
        'quantity',
        'location_id',
        'invoice_no',
        'cost_price',
    ];
    protected $casts = [
        'receiving_date' => 'date', // <--- this converts the string to Carbon
    ];
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
    public function location()
    {
        return $this->belongsTo(BusinessLocation::class, 'location_id');
    }
}
