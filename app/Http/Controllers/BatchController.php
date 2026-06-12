<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\BusinessLocation;
use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Bus\Batch as BusBatch;
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
        $batch = Batch::find($id);

        if (!$batch) {
            return back()->with('error', 'Batch not found.');
        }

        if ($batch->inventories()->exists()) {
            return back()->with('error', 'Cannot delete batch: It is used in another table.');
        }

        $batch->delete();

        //  Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($batch)
            ->withProperties(['data' => $batch])
            ->log('Deleted a batch ');

        return back()->with('success', ' Batch Deleted Successfully.');
    }
    public function getBatches($item_id)
    {
        $batches = Batch::where('item_id', $item_id)->get();
        return response()->json($batches);
    }

    public function edit_Batches(Request $request, $id)
    {

        $batch = Batch::find($id);
        $batch->update([
            'item_id' => $request->id,
            'batch_number' => $request->batch_number,
            'manufacture_date' > $request->manufacture_date,
        ]);
        return back()->with('success', ' Batch Updated Successfully.');
    }
}
