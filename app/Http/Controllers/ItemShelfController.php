<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemShelf;
use App\Models\Shelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemShelfController extends Controller
{
    public function index($id)
    {
        $item = Item::where('id', $id)->first();
        $shelfs = Shelf::all();
        $itemshelfs = ItemShelf::where('item_id', $id)->get();
        return view('pages.items.setShelf')
            ->with('shelfs', $shelfs)
            ->with('itemshelfs', $itemshelfs)
            ->with('item', $item);
    }
    public function addItemShelf(Request $request)
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
        $validated = $request->validate([
            'item_id' => ['required'],
            'shelf_id' => ['required'],
        ]);


        $shelfs = ItemShelf::create([
            'item_id' => $request->item_id,
            'shelf_id' => $request->shelf_id,
        ]);


        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($shelfs)
            ->withProperties(['data' => $shelfs])
            ->log('Set shelf for item');

        return redirect('/items')->with('success', 'Shelf set successfully.');
    }

    public function deleteItemShelf($id)
    {
        $shelfs = ItemShelf::findOrFail($id);

        $shelfs->delete();

        //  Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($shelfs)
            ->withProperties(['data' => $shelfs])
            ->log('Deleted a shelfs ');

        return back()->with('success', ' shelf Deleted Successfully.');
    }
}
