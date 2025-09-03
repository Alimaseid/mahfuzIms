<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'reference_number',
        'sales_person',
        'sales_type',
        'SM_status',
        'location_id',
        'payment_status',
        'grand_total',
        'rejectReasone',
        'SM_status'
    ];

    public function salesDetails():HasMany
    {
        return $this->hasMany(SalesOrderDetail::class,'sales_order_id');
    }

    public function customer():BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
