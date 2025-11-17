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
        'item_id',
        'batch_id',
        'item_name',
        'quantity',
    ];

    public function requisition(): BelongsTo
    {
        return $this->belongsTo(Requisition::class);
    }
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }
    public function location(): BelongsTo
    {
        return $this->belongsTo(BusinessLocation::class);
    }
}
