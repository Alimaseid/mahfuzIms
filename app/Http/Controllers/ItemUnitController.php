<?php

namespace App\Http\Controllers;

use App\Models\ItemUnit;
use Illuminate\Http\Request;

class ItemUnitController extends Controller
{
    public function index()
    {

     $item_units =  ItemUnit::all();

       return view('pages.item_unit.unit',compact('item_units'));
    }

    public function addItemUnit(Request $request){
        $Data = $request->validate([
            'unit' => ['required'],
        ]);
       ItemUnit::create([
            'unit'=>$request->unit,

        ]);
        return back()->with('success','Item Unit Added Successfully.');

    }

    public function editItemUnit(Request $request,$id){

        ItemUnit::where('id',$id)->update([
            'unit'=>$request->unit

        ]);
        return back()->with('success',' Edit Item Unit Successfully.');

    }

    public function deleteItemUnit($id){
        ItemUnit::where('id',$id)->delete();
        return back()->with('success',' Item Unit Deleted Successfully.');

    }
}
