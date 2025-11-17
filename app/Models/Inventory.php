<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $fillable  = ['item_id', 'batch_id', 'location_id', 'quantity'];
    // Inventory.php
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
    public function location()
    {
        return $this->belongsTo(BusinessLocation::class, 'location_id');
    }

    protected static function booted()
    {
        static::saved(function ($inventory) {
            Inventory::checkReorder($inventory->item_id, $inventory->location_id);
        });

        static::updated(function ($inventory) {
            Inventory::checkReorder($inventory->item_id, $inventory->location_id);
        });
    }

    public static function checkReorder($itemId, $locationId)
    {
        $item = Item::find($itemId);
        if (!$item) return;

        $stock = Inventory::where('item_id', $itemId)
            ->where('location_id', $locationId)
            ->sum('quantity');

        if ($stock <= $item->reorder_level) {
            PurchasePlan::updateOrCreate(
                ['item_id' => $itemId, 'location_id' => $locationId],
                ['required_qty' => $item->reorder_level - $stock]
            );
        } else {
            PurchasePlan::where('item_id', $itemId)
                ->where('location_id', $locationId)
                ->delete();
        }
    }
}
