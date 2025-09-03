<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequisitionDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'requisition_id',
        'owner_id',
        'item_id',
        'item_name',
        'quantity',
    ];

    // public function requisition():BelongsTo
    // {
    //     return $this->belongsTo(Requisition::class);
    // }
}
