<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Requisition extends Model
{
    use HasFactory;
    protected $fillable = [
        'request_from',
        'request_by',
        'request_to',
        'transfer_by',
        'ship_by',
    ];

    public function itemList(): HasMany
    {
        return $this->hasMany(RequisitionDetail::class);
    }
    public function location(): BelongsTo
    {
        return $this->belongsTo(BusinessLocation::class);
    }
    public function requestTo()
    {
        return $this->belongsTo(BusinessLocation::class, 'request_to');
    }

    public function requestFrom()
    {
        return $this->belongsTo(BusinessLocation::class, 'request_from');
    }
    public function details()
    {
        return $this->hasMany(RequisitionDetail::class);
    }
}
