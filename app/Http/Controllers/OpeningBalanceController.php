<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\BusinessLocation;
use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class OpeningBalanceController extends Controller
{

    public function index($id)
    {
        $item = Item::where('id', $id)->first();
        $locations = BusinessLocation::all();
        $batchs = Batch::all();
        return view('pages.items.openingBalance')
            ->with('item', $item)
            ->with('batchs', $batchs)
            ->with('locations', $locations);
    }

    public function addOpening_balance(Request $request)
    {
        $validated = $request->validate([
            'item_id' => ['required'],
            'batch_id' => ['required'],
            'location_id' => ['required'],
            'quantity' => ['required'],
        ]);

        // Find inventory for this item & location
        $inventory = Inventory::where('item_id', $request->item_id)
            ->where('batch_id', $request->batch_id)
            ->where('location_id', $request->location_id)
            ->first();

        if ($inventory) {
            // Update existing inventory
            $inventory->quantity = $request->quantity;
            $inventory->save();
        } else {
            // Create new inventory
            $inventory = Inventory::create([
                'item_id' => $request->item_id,
                'batch_id' => $request->batch_id,
                'location_id' => $request->location_id,
                'quantity' => $request->quantity,
            ]);
        }

        // Update total quantity in items table (sum of all inventories for this item)
        $totalQuantity = Inventory::where('item_id', $request->item_id)->sum('quantity');
        $item = Item::find($request->item_id);
        $item->quantity = $totalQuantity;
        $item->save();

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($inventory)
            ->withProperties(['data' => $inventory])
            ->log('Set opening balance for item');

        return redirect('/items')->with('success', 'Opening balance set successfully.');
    }
}
