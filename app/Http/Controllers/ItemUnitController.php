<?php

namespace App\Http\Controllers;

use App\Models\ItemUnit;
use Illuminate\Http\Request;

class ItemUnitController extends Controller
{
    public function index()
    {

        $item_units =  ItemUnit::all();

        return view('pages.item_unit.unit', compact('item_units'));
    }

    public function addItemUnit(Request $request)
    {
        $validated = $request->validate([
            'unit' => ['required'],
        ]);

        $unit = ItemUnit::create([
            'unit' => $request->unit,
        ]);

        // ✅ Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($unit)
            ->withProperties(['data' => $unit->toArray()])
            ->log('Added new Item Unit');

        return back()->with('success', 'Item Unit Added Successfully.');
    }

    public function editItemUnit(Request $request, $id)
    {
        $unit = ItemUnit::findOrFail($id);

        $unit->update([
            'unit' => $request->unit,
        ]);

        // ✅ Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($unit)
            ->withProperties(['data' => $unit->toArray()])
            ->log('Edited Item Unit');

        return back()->with('success', 'Edit Item Unit Successfully.');
    }

    public function deleteItemUnit($id)
    {
        $unit = ItemUnit::findOrFail($id);

        // ✅ Log activity *before* deleting
        activity()
            ->causedBy(auth()->user())
            ->performedOn($unit)
            ->withProperties(['data' => $unit->toArray()])
            ->log('Deleted Item Unit');

        $unit->delete();

        return back()->with('success', 'Item Unit Deleted Successfully.');
    }
}
