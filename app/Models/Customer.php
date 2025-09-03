<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'company_name',
        'email',
        'phone',
        'tin',
        'address',
        'total_balance'
    ];
}
