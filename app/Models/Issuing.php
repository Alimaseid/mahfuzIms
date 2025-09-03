<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issuing extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'owner_Id', 'issued_from', 'issued_to','voucher_number', 'date', 'issued_by', 'issuing_detail_id','status'
    ];
}
