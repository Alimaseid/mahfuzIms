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
use App\Models\Shelf;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::orderBy('id', 'desc')->get();
        $item_owners = ItemOwner::all();
        $owners = Owner::all();
        $categories = Category::all();
        $shelfs = Shelf::all();
        $item_units= ItemUnit::all();
        $location = BusinessLocation::all();
        return view('pages.items.item')
        ->with('location', $location)
        ->with('owners', $owners)
        ->with('item_owners', $item_owners)
        ->with('categories', $categories)
        ->with('shelfs', $shelfs)
        ->with('items', $items)
        ->with('item_units',$item_units);
    }

    public function addItem(Request $request){
        $photo = $request->file('image');
        $doc_path = '';
        if($photo){
            $doc_name = $photo->getClientOriginalName();
            $doc_path = $photo->move('images/item-iamges',$doc_name);
         }

        $photos = $request->file('image2');
        $doc_paths = '';
         if($photos){
            $doc_names = $photos->getClientOriginalName();
            $doc_paths = $photos->move('images/item-iamges',$doc_names);
         }
       Item::create([
        'item_name' =>$request->item_name,
        'shelves_id' =>$request->shelves_id,
        'category' =>$request->category,
        'product_code' =>$request->product_code,
        'part_number' =>$request->part_number,
        'unit' =>$request->unit,
        'cost_price' =>$request->cost_price,
        'selling_price1' =>$request->selling_price1,
        'selling_price2' =>$request->selling_price2,
        'item_code' =>$request->item_code,
        'image' =>$doc_path,
        'image2' =>$doc_paths,
        'bar_code' =>$request->bar_code,
        'status' =>'Active',
        'description' >$request->description,
        'reorder' => $request->reorder,
        'quantity' =>$request->quantity,
        'brand' => $request->brand
        ]);
        return back()->with('success','Item Added Successfully.');
    }

    public function editItem(Request $request,$id){
        $photo = $request->file('image');
        $img = Item::where('id',$id)->first();
        $doc_path = $img->image;
        if($photo){
            $doc_name = $photo->getClientOriginalName();
            $doc_path = $photo->move('images/item-images',$doc_name);
         }

        $photos = $request->file('image2');
        $doc_paths = $img->image2;
         if($photos){
            $doc_names = $photos->getClientOriginalName();
            $doc_paths = $photos->move('images/item-iamges',$doc_names);
         }
        Item::where('id',$id)->update([
         'item_name' =>$request->item_name,
         'shelves_id' =>$request->shelves_id,
         'category' =>$request->category,
         'product_code' =>$request->product_code,
         'part_number' =>$request->part_number,
         'unit' =>$request->unit,
         'cost_price' =>$request->cost_price,
         'selling_price1' =>$request->selling_price1,
         'selling_price2' =>$request->selling_price2,
         'item_code' =>$request->item_code,
         'image' =>$doc_path,
         'image2' =>$doc_paths,
         'bar_code' =>$request->bar_code,
         'quantity' =>$request->quantity,
         'brand' =>$request->brand,
         'reorder' => $request->reorder,
         'description' => $request->description,

         ]);


         return back()->with('success','Item Updated Successfully.');
     }

     public function searchItem(Request $request){
        $items = Item::Where('item_name','like','%'. $request->name.'%')
        ->orWhere('product_code','like','%'. $request->name.'%')
        ->get();
        return json_encode($items);
     }

     public function deleteItem($id){
        Item::where('id',$id)->delete();
        return back()->with('success',' Item Deleted Successfully.');

    }
}
