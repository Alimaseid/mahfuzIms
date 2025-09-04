<?php

namespace App\Http\Controllers;

use App\Models\BusinessLocation;
use App\Models\Shelf;
use Illuminate\Http\Request;

class ShelfController extends Controller
{
    public function index()
    {
        $locations = BusinessLocation::all();
        $shelfs = Shelf::all();
        return view('pages.shelfs.shelf', compact('locations', 'shelfs'));
    }

    public function addShelf(Request $request)
    {
        $data = $request->validate([
            'business_locations_id' => ['required'],
            'shelf_name'            => ['required'],
        ]);

        $shelf = Shelf::create([
            'business_locations_id' => $request->business_locations_id,
            'shelf_name'            => $request->shelf_name,
            'description'           => $request->description,
        ]);

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($shelf)
            ->withProperties([
                'business_location' => $request->business_locations_id,
                'shelf_name'        => $request->shelf_name,
            ])
            ->log('Added new Shelf');

        return back()->with('success', 'Shelf Added Successfully.');
    }

    // ✅ Edit Shelf
    public function editShelf(Request $request, $id)
    {
        $shelf = Shelf::findOrFail($id);

        $shelf->update([
            'business_locations_id' => $request->business_locations_id,
            'shelf_name'            => $request->shelf_name,
            'description'           => $request->description,
        ]);

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($shelf)
            ->withProperties([
                'shelf_id'      => $shelf->id,
                'new_name'      => $request->shelf_name,
                'business_location' => $request->business_locations_id,
            ])
            ->log('Edited Shelf');

        return back()->with('success', 'Edit Shelf Successfully.');
    }

    // ✅ Delete Shelf
    public function deleteShelf($id)
    {
        $shelf = Shelf::findOrFail($id);

        // Log before deleting
        activity()
            ->causedBy(auth()->user())
            ->performedOn($shelf)
            ->withProperties([
                'shelf_id'   => $shelf->id,
                'shelf_name' => $shelf->shelf_name,
            ])
            ->log('Deleted Shelf');

        $shelf->delete();

        return back()->with('success', 'Shelf Deleted Successfully.');
    }
}
