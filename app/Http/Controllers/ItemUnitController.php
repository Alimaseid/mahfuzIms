<?php

namespace App\Http\Controllers;

use App\Models\ItemUnit;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemUnitController extends Controller
{
    public function index()
    {

        $item_units =  ItemUnit::orderBy('id', 'desc')->paginate(200);
        $permission = Role::where('id', Auth::user()->role)->first();

        return view('pages.item_unit.unit', compact('item_units', 'permission'));
    }

    public function addItemUnit(Request $request)
    {
        $data = $request->validate([
            'unit' => 'required|unique:item_units,unit',
        ], [
            'unit.unique' => 'This Unit already exists. Please choose another name.',
            'unit.required' => 'Unit is required.',
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
