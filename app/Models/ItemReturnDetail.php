<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemReturnDetail extends Model
{
    use HasFactory;
    protected $fillable =[
        'return_id', 'item_id', 'quantity', 'price', 'return_to',
    ];
}
