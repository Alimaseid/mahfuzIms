<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemShelf extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'shelf_id'];

    // Relations
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function shelf()
    {
        return $this->belongsTo(Shelf::class, 'shelf_id');
    }
}
