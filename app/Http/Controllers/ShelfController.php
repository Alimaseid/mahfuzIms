<?php

namespace App\Http\Controllers;

use App\Models\BusinessLocation;
use App\Models\Shelf;
use Illuminate\Http\Request;

class ShelfController extends Controller
{
    public function index()
    {
        $locations= BusinessLocation::all();
        $shelfs= Shelf::all();
        return view('pages.shelfs.shelf',compact('locations','shelfs'));

    }

       public function addShelf(Request $request){
        $Data = $request->validate([
            'business_locations_id' => ['required'],
            'shelf_name' => ['required'],

        ]);
       Shelf::create([
            'business_locations_id'=>$request->business_locations_id,
            'shelf_name'=>$request->shelf_name,
            'description'=>$request->description,

        ]);
        return back()->with('success','Shelf Added Successfully.');

    }

    public function editShelf(Request $request,$id){

        Shelf::where('id',$id)->update([
            'business_locations_id'=>$request->business_locations_id,
            'shelf_name'=>$request->shelf_name,
            'description'=>$request->description

        ]);
        return back()->with('success',' Edit Shelf Successfully.');

    }

    public function deleteShelf($id){
        Shelf::where('id',$id)->delete();
        return back()->with('success',' Shelf Deleted Successfully.');

    }
}
