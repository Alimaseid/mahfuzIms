<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shelf extends Model
{
    use HasFactory;
       protected $fillable = ['business_locations_id','shelf_name','description'];

     public function location()
    {
        return $this->belongsTo(BusinessLocation::class, 'business_locations_id');
    }
}
