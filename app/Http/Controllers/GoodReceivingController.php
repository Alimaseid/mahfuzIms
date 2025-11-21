<?php

namespace App\Http\Controllers;

use App\Imports\GoodReceivingImport;
use App\Models\Batch;
use App\Models\BusinessLocation;
use App\Models\Category;
use App\Models\GoodReceiving;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\ItemUnit;
use App\Models\Role;
use App\Models\Shelf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GoodReceivingController extends Controller
{


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        $expectedHeaders = [
            'itemname',
            'category',
            'shelf',
            'unit',
            'partnumber1',
            'partnumber2',
            'itemcode',
            'batchno',
            'brand',
            'price1',
            'price2',
            'reorder'
        ];

        try {
            // Read Excel as array
            $data = Excel::toArray(new GoodReceivingImport, $request->file('file'));

            if (empty($data) || !isset($data[0][0])) {
                return back()->with('error', 'Excel file is empty or invalid.');
            }

            $headers = array_map(function ($h) {
                return strtolower(str_replace(' ', '', $h));
            }, array_keys($data[0][0])); // first row

            // Compare headers
            foreach ($expectedHeaders as $header) {
                if (!in_array($header, $headers)) {
                    return back()->with('error', "Invalid file format or  Missing column: {$header}");
                }
            }

            // If headers are ok → import
            Excel::import(new GoodReceivingImport, $request->file('file'));
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        return back()->with('success', 'Items imported successfully!');
    }

    public function index()
    {
        $good_receivings = GoodReceiving::orderBy('id', 'desc')->paginate(200);
        $categories = Category::all();
        $shelfs = Shelf::all();
        $item_units = ItemUnit::all();
        $items = Item::all();
        $batchs = Batch::all();
        $businessLocations = BusinessLocation::all();
        $permission = Role::where('id', Auth::user()->role)->first();

        return view('pages.goodreceiving.good_receiving')
            ->with('categories', $categories)
            ->with('businessLocations', $businessLocations)
            ->with('good_receivings', $good_receivings)
            ->with('shelfs', $shelfs)
            ->with('items', $items)
            ->with('batchs', $batchs)
            ->with('permission', $permission)
            ->with('item_units', $item_units);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addGoodReceiving(Request $request)
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
        $request->validate([
            'item_id'        => 'required',
            'batch_id'        => 'required',
            'receiving_date' => 'required',
            'location_id'  => 'required',
            'invoice_no'     => 'required',
            'cost_price'     => 'required',
            'quantity'       => 'required',
        ]);
        // Save receiving record
        $receiving = GoodReceiving::create($request->all());

        // Update inventory for that location
        $inventory = Inventory::firstOrNew([
            'item_id'   => $request->item_id,
            'batch_id'   => $request->batch_id,
            'location_id'  => $request->location_id,
        ]);

        $inventory->quantity = ($inventory->quantity ?? 0) + $request->quantity;
        $inventory->save();

        // ✅ Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($receiving)
            ->withProperties(['data' => $receiving->toArray()])
            ->log('Added a new Good Receiving');

        return back()->with('success', 'Good Receiving Added Successfully.');
    }


    public function editGoodReceiving(Request $request, $id)
    {

        $request->validate([
            'item_id'        => 'required|exists:items,id',
            'batch_id'        => 'required',
            'receiving_date' => 'required|date',
            'location_id'    => 'required|string',
            'invoice_no'     => 'required|string|unique:good_receivings,invoice_no,' . $id, // ignore current record
            'cost_price'     => 'required|numeric|min:0',
            'quantity'       => 'required|integer|min:1',
        ]);

        $receiving = GoodReceiving::findOrFail($id);

        // ⚠️ Step 1: Restore old inventory before update
        $oldInventory = Inventory::where('item_id', $receiving->item_id)
            ->where('location_id', $receiving->location_id)
            ->where('batch_id', $receiving->batch_id)
            ->first();

        if ($oldInventory) {
            $oldInventory->quantity -= $receiving->quantity; // remove old qty
            $oldInventory->save();
        }

        // ⚠️ Step 2: Update receiving record
        $receiving->update($request->all());

        // ⚠️ Step 3: Apply new inventory qty
        $inventory = Inventory::firstOrNew([
            'item_id'    => $request->item_id,
            'batch_id'    => $request->batch_id,
            'location_id' => $request->location_id,
        ]);

        $inventory->quantity = ($inventory->quantity ?? 0) + $request->quantity;
        $inventory->save();

        // ✅ Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($receiving)
            ->withProperties(['data' => $receiving->toArray()])
            ->log('Updated Good Receiving');

        return back()->with('success', 'Good Receiving Updated Successfully.');
    }


    public function deleteGoodReceivings($id)
    {

        $receiving = GoodReceiving::findOrFail($id);

        $inventory = Inventory::firstOrNew([
            'item_id'    => $receiving->item_id,
            'batch_id'    => $receiving->batch_id,
            'location_id' => $receiving->location_id,
        ]);

        $inventory->quantity = ($inventory->quantity ?? 0) - $receiving->quantity;
        $inventory->save();
        // ✅ Log activity before deleting
        activity()
            ->causedBy(auth()->user())
            ->performedOn($receiving)
            ->withProperties(['order_id' => $receiving->id])
            ->log('Deleted  goodreceiving Order');

        $receiving->delete();

        return back()->with('success', 'Delete Good receiving Successfully.');
    }
    public function getBatches($itemId)
    {
        $batches = \App\Models\Batch::where('item_id', $itemId)
            ->select('id', 'batch_number')
            ->get();

        return response()->json($batches);
    }
}
