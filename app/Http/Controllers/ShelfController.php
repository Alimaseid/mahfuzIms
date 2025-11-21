<?php

namespace App\Http\Controllers;

use App\Models\BusinessLocation;
use App\Models\Role;
use App\Models\Shelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShelfController extends Controller
{
    public function index()
    {
        $locations = BusinessLocation::all();
        $shelfs = Shelf::orderBy('id', 'desc')->paginate(200);
        $permission = Role::where('id', Auth::user()->role)->first();
        return view('pages.shelfs.shelf', compact('locations', 'shelfs', 'permission'));
    }

    public function addShelf(Request $request)
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
            'business_locations_id' => 'required',
            'shelf_name' => 'required|unique:shelves,shelf_name',
        ], [
            'shelf_name.unique' => 'This shelf name already exists. Please choose another name.',
            'shelf_name.required' => 'Shelf name is required.',
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
