<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ItemBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemBatchController extends Controller
{
    //

    public function index()
    {

        $item_batch =  ItemBatch::orderBy('id', 'desc')->get();

        return view('pages.ItemBatch.index', compact('item_batch'));
    }

    public function addItemBatch(Request $request)
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
        $data = $request->validate([
            'batch_number' => 'required|unique:item_batches,batch_number',
        ], [
            'batch_number.unique' => 'This Batch Number already exists. Please choose another name.',
            'batch_number.required' => 'Batch Number is required.',
        ]);

        $unit = ItemBatch::create([
            'batch_number' => $request->batch_number,
        ]);

        // ✅ Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($unit)
            ->withProperties(['data' => $unit->toArray()])
            ->log('Added new Item Batch');

        return back()->with('success', 'Item Unit Added Successfully.');
    }

    public function editItemBatch(Request $request, $id)
    {


        $unit = ItemBatch::findOrFail($id);

        $unit->update([
            'batch_number' => $request->batch_number,
        ]);

        // ✅ Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($unit)
            ->withProperties(['data' => $unit->toArray()])
            ->log('Edited Item Batch');

        return back()->with('success', 'Edit Item Batch Successfully.');
    }

    public function deleteItemBatch($id)
    {
        $unit = ItemBatch::findOrFail($id);

        // ✅ Log activity *before* deleting
        activity()
            ->causedBy(auth()->user())
            ->performedOn($unit)
            ->withProperties(['data' => $unit->toArray()])
            ->log('Deleted Item Batch');

        $unit->delete();

        return back()->with('success', 'Item Batch Deleted Successfully.');
    }
}
