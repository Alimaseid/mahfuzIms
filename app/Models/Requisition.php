<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Requisition extends Model
{
    use HasFactory;
    protected $fillable = [
        'request_from',
        'request_by',
        'transfer_from_store',
        'transfer_from_owner',
        'transfer_by',
        'issued_by',
        'ship_by',
    ];

    public function itemList():HasMany
    {
        return $this->hasMany(RequisitionDetail::class);
    }
}
