<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; // custom PK
    protected $fillable = ['item_id', 'batch_number', 'manufacture_date'];

    // Relations
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
