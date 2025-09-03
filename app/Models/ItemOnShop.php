<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemOnShop extends Model
{
    use HasFactory;
    protected $fillable =[
        'item_id', 'item_name', 'location_id', 'location_type', 'location_name', 'qauntity',

    ];

    public function item():BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
