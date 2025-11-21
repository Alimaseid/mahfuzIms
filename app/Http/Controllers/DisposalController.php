<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\BusinessLocation;
use App\Models\Disposal;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DisposalController extends Controller
{
    public function index()
    {
        $items = Inventory::all();
        $disposals = Disposal::orderBy('id', 'desc')->paginate(200);
        $businessLocations = BusinessLocation::all();
        $permission = Role::where('id', Auth::user()->role)->first();
        return view('pages.disposal.disposal', compact('items', 'disposals', 'businessLocations', 'permission'));
    }


    public function addDisposal(Request $request)
    {
        // 1️⃣ Reject reused tokens
        $exists = DB::table('request_tokens')
            ->where('token', $request->request_token)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Duplicate submission blocked.');
        }

        // 2️⃣ Store token immediately so duplicates are blocked
        DB::table('request_tokens')->insert([
            'token' => $request->request_token,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 3️⃣ Now process disposal normally
        return DB::transaction(function () use ($request) {

            $request->validate([
                'item_id' => 'required',
                'batch_id' => 'required',
                'location_id' => 'required',
                'quantity' => 'required|integer|min:1',
            ]);

            $inventory = Inventory::where('item_id', $request->item_id)
                ->where('location_id', $request->location_id)
                ->where('batch_id', $request->batch_id)
                ->lockForUpdate()
                ->first();

            if (!$inventory) {
                return back()->with('error', 'Inventory not found.');
            }

            if ($inventory->quantity < $request->quantity) {
                return back()->with('error', 'Not enough quantity.');
            }

            $disposal = Disposal::create([
                'item_id' => $request->item_id,
                'batch_id' => $request->batch_id,
                'location_id' => $request->location_id,
                'quantity' => $request->quantity,
                'reason' => $request->reason,
            ]);

            $inventory->quantity -= $request->quantity;
            $inventory->save();

            return back()->with('success', 'Disposal Added Successfully.');
        });
    }



    public function editDisposal(Request $request, $id)
    {
        $request->validate([
            'item_id'    => 'required',
            'batch_id'    => 'required',
            'location_id' => 'required',
            'quantity'   => 'required|integer|min:1',
            'reason'     => 'nullable|string',
        ]);

        $disposal = Disposal::findOrFail($id);

        // Restore old inventory
        $oldInventory = Inventory::where('item_id', $disposal->item_id)
            ->where('location_id', $disposal->location_id)
            ->where('batch_id', $request->batch_id)
            ->first();
        if ($oldInventory) {
            $oldInventory->quantity += $disposal->quantity;
            $oldInventory->save();
        }

        // Update disposal
        $disposal->update([
            'item_id'    => $request->item_id,
            'batch_id'    => $request->batch_id,
            'location_id' => $request->location_id,
            'quantity'   => $request->quantity,
            'reason'     => $request->reason,
        ]);

        // Apply new inventory deduction
        $newInventory = Inventory::where('item_id', $request->item_id)
            ->where('location_id', $request->location_id)
            ->where('batch_id', $request->batch_id)
            ->first();
        if ($newInventory) {
            $newInventory->quantity -= $request->quantity;
            $newInventory->save();
        }

        activity()
            ->causedBy(auth()->user())
            ->performedOn($disposal)
            ->withProperties(['data' => $disposal])
            ->log('Edited disposal');

        return back()->with('success', 'Disposal Edited Successfully.');
    }


    public function deleteDisposal($id)
    {
        $disposal = Disposal::findOrFail($id);

        $inventory = Inventory::where('item_id', $disposal->item_id)
            ->where('location_id', $disposal->location_id)
            ->where('batch_id', $disposal->batch_id)
            ->first();

        if ($inventory) {
            $inventory->quantity += $disposal->quantity;
            $inventory->save();
        }

        $disposal->delete();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($disposal)
            ->withProperties(['data' => $disposal])
            ->log('Deleted disposal');

        return back()->with('success', 'Disposal Deleted Successfully.');
    }
    public function getItems(Request $request)
    {
        $search = $request->input('search');

        $items = Inventory::with(['item', 'batch'])
            ->whereHas('item', function ($q) use ($search) {
                $q->where('item_name', 'like', "%$search%")
                    ->orWhere('product_code', 'like', "%$search%");
            })
            ->take(20) // limit for performance
            ->get();

        return response()->json($items->map(function ($row) {
            return [
                'item_id' => $row->id,
                'item_name' => $row->item->item_name,
                'product_code' => $row->item->product_code,
                'batch_number' => $row->batch->batch_number
            ];
        }));
    }
}
