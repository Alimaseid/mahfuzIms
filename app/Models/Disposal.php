<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposal extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'batch_id', 'quantity', 'reason', 'location_id'];

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
