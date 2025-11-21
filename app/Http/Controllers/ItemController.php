<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Owner;
use App\Models\Category;
use App\Models\ItemOwner;
use Illuminate\Http\Request;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\BusinessLocation;
use App\Models\ItemUnit;
use App\Models\Role;
use App\Models\Shelf;
use App\Models\SalesOrderDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::orderBy('id', 'desc')->paginate(500);
        $categories = Category::all();
        $shelfs = Shelf::all();
        $item_units = ItemUnit::all();
        $location = BusinessLocation::all();
        $user = User::where('id', Auth::user()->id)->first();
        $permission = Role::where('id', $user->role)->first();

        return view('pages.items.item')
            ->with('location', $location)
            ->with('categories', $categories)
            ->with('shelfs', $shelfs)
            ->with('items', $items)
            ->with('permission', $permission)
            ->with('item_units', $item_units);
    }

    public function addItem(Request $request)
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
            'item_code'    => 'required|string|max:255|unique:items,item_code',
            'part_number'  => 'nullable|string|max:255|unique:items,part_number',
            'product_code' => 'nullable|string|max:255|unique:items,product_code',
        ]);
        $photo = $request->file('image');
        $doc_path = '';
        if ($photo) {
            $doc_name = $photo->getClientOriginalName();
            $doc_path = $photo->move('images/item-iamges', $doc_name);
        }

        $photos = $request->file('image2');
        $doc_paths = '';
        if ($photos) {
            $doc_names = $photos->getClientOriginalName();
            $doc_paths = $photos->move('images/item-iamges', $doc_names);
        }
        $item = Item::create([
            'item_name' => $request->item_name,
            'shelf' => $request->shelf,
            'category' => $request->category,
            'product_code' => $request->product_code,
            'part_number' => $request->part_number,
            'unit' => $request->unit,
            'other_unit' => $request->other_unit,
            'cost_price' => $request->cost_price,
            'selling_price1' => $request->selling_price1,
            'selling_price2' => $request->selling_price2,
            'item_code' => $request->item_code,
            'image' => $doc_path,
            'image2' => $doc_paths,
            'bar_code' => $request->bar_code,
            'status' => 'Active',
            'description' > $request->description,
            'reorder' => $request->reorder,
            'reorder_for_shop' => $request->reorder_for_shop,
            'quantity' => $request->quantity,
            'brand' => $request->brand
        ]);
        activity()
            ->causedBy(auth()->user())
            ->performedOn($item)
            ->withProperties(['data' => $item])
            ->log('Added new item');
        return back()->with('success', 'Item Added Successfully.');
    }

    public function editItem(Request $request, $id)
    {
        // $request->validate([
        //     'item_code'    => 'required|string|max:255|unique:items,item_code',
        //     'part_number'  => 'nullable|string|max:255|unique:items,part_number',
        //     'product_code' => 'nullable|string|max:255|unique:items,product_code',
        // ]);
        $photo = $request->file('image');
        $img = Item::where('id', $id)->first();
        $doc_path = $img->image;
        if ($photo) {
            $doc_name = $photo->getClientOriginalName();
            $doc_path = $photo->move('images/item-images', $doc_name);
        }

        $photos = $request->file('image2');
        $doc_paths = $img->image2;
        if ($photos) {
            $doc_names = $photos->getClientOriginalName();
            $doc_paths = $photos->move('images/item-iamges', $doc_names);
        }
        $item =  Item::find($id);
        $item->update([
            'item_name' => $request->item_name,
            'shelf' => $request->shelf,
            'category' => $request->category,
            'product_code' => $request->product_code,
            'part_number' => $request->part_number,
            'unit' => $request->unit,
            'other_unit' => $request->other_unit,
            'cost_price' => $request->cost_price,
            'selling_price1' => $request->selling_price1,
            'selling_price2' => $request->selling_price2,
            'item_code' => $request->item_code,
            'image' => $doc_path,
            'image2' => $doc_paths,
            'bar_code' => $request->bar_code,
            'quantity' => $request->quantity,
            'brand' => $request->brand,
            'reorder' => $request->reorder,
            'reorder_for_shop' => $request->reorder_for_shop,
            'description' => $request->description,

        ]);
        activity()
            ->causedBy(auth()->user())
            ->performedOn($item)
            ->withProperties(['data' => $item])
            ->log('Edited new item');

        return back()->with('success', 'Item Updated Successfully.');
    }

    public function searchItem(Request $request)
    {
        $items = Item::Where('item_name', 'like', '%' . $request->name . '%')
            ->orWhere('product_code', 'like', '%' . $request->name . '%')
            ->get();
        return json_encode($items);
    }

    public function deleteItem($id)
    {
        $item = Item::where('id', $id)->first();
        if ($item->SalesOrderDetail()->exists() || $item->inventory()->exists()) {
            return back()->with('error', 'Cannot delete item: It is used in others table.');
        }
        $item->delete();
        activity()
            ->causedBy(auth()->user())
            ->performedOn($item)
            ->withProperties(['data' => $item])
            ->log('Deleted new item');
        return back()->with('success', ' Item Deleted Successfully.');
    }
}
