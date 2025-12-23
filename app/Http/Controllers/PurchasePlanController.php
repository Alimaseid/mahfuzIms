<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Item;
use App\Models\PurchasePlan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchasePlanController extends Controller
{
    public function index()
    {
        $plans = Inventory::select('inventories.*')
            ->join('items', 'items.id', '=', 'inventories.item_id')
            ->whereColumn('inventories.quantity', '<', 'items.reorder')
            ->with('item')
            ->orderBy('id', 'desc')->paginate(200);
        $user = User::where('id', Auth::user()->id)->first();
        $permission = Role::where('id', $user->role)->first();
        return view('pages.goodreceiving.purchase_plan', compact('plans', 'permission'));
    }
    public function plannedItem()
    {
        $plans = PurchasePlan::with('item')->orderBy('id', 'desc')->paginate(200);
        $permission = Role::where('id', Auth::user()->role)->first();
        return view('pages.goodreceiving.planned_item', compact('plans', 'permission'));
    }
    public function move(Request $request, $id)
    {

        $item = Item::find($id);
        $inventoryQty = Inventory::where('item_id', $id)->sum('quantity');

        $plans =  PurchasePlan::Create([
            'item_id' => $id,
            'required_qty' => $request->quantity,
            'message' => $request->message
        ]);
        //  Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($plans)
            ->withProperties(['data' => $plans])
            ->log('Moved Item to Purchase Planned Item ');

        return back()->with('success', 'Item moved to purchase plan');
    }
    public function deletePlans($id)
    {
        $plans = PurchasePlan::findOrFail($id);

        $plans->delete();

        //  Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($plans)
            ->withProperties(['data' => $plans])
            ->log('Deleted a Purchase Plans ');

        return back()->with('success', ' PurchasePlan Deleted Successfully.');
    }
}
