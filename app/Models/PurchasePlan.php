<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasePlan extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'location_id', 'required_qty', 'message'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function location()
    {
        return $this->belongsTo(BusinessLocation::class);
    }
}
