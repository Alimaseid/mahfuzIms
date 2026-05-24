<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\BusinessLocation;
use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index($id)
    {
        $item = Item::where('id', $id)->first();
        $batchs = Batch::where('item_id', $id)->get();
        return view('pages.items.setBatch')
            ->with('batchs', $batchs)
            ->with('item', $item);
    }
    public function addBatch(Request $request)
    {
        $validated = $request->validate([
            'item_id' => ['required'],
            'batch_number' => ['required'],
        ]);


        $batch = Batch::create([
            'item_id' => $request->item_id,
            'batch_number' => $request->batch_number,
            'manufacture_date' => $request->manufacture_date,
        ]);


        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($batch)
            ->withProperties(['data' => $batch])
            ->log('Set batch for item');

        return back()->with('success', 'Batch set successfully.');
    }

    public function deleteBatchs($id)
    {
        $batchs = batch::findOrFail($id);

        $batchs->delete();

        //  Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($batchs)
            ->withProperties(['data' => $batchs])
            ->log('Deleted a batch ');

        return back()->with('success', ' Batch Deleted Successfully.');
    }
    public function getBatches($item_id)
    {
        $batches = Batch::where('item_id', $item_id)->get();
        return response()->json($batches);
    }
}
