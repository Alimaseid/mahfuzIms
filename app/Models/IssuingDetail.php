<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssuingDetail extends Model
{
    use HasFactory;
    protected $fillable = ['issuing_id', 'item_id', 'item_name', 'qauntity','owner_id'];
}
