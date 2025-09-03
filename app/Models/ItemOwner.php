<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemOwner extends Model
{
    use HasFactory;
    protected $fillable =[

        'owner_id', 'item_id', 'item_name', 'quantity','location_id',
    ];
}
