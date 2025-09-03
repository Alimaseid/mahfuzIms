<?php

namespace App\Http\Controllers;

use App\Models\Disposal;
use App\Models\Item;
use Illuminate\Http\Request;

class DisposalController extends Controller
{
    public function index()
    {
        $items= Item::all();
        $disposals= Disposal::all();
        return view('pages.disposal.disposal',compact('items','disposals'));

    }

       public function addDisposal(Request $request){
        $Data = $request->validate([
            'item_id' => ['required'],
            'quantity' => ['required'],

        ]);
       $disposal=Disposal::create([
            'item_id'=>$request->item_id,
            'quantity'=>$request->quantity,
            'reason'=>$request->reason,

        ]);

            $item= Item::where('id',$disposal->item_id)->first();
            $item->quantity = $item->quantity - $request->quantity;
            $item->update();
        return back()->with('success','Disposal Added Successfully.');

    }

    public function editDisposal(Request $request,$id){

        Disposal::where('id',$id)->update([
            'item_id'=>$request->item_id,
            'quantity'=>$request->quantity,
            'reason'=>$request->reason,

        ]);
        return back()->with('success',' Edit Disposal Successfully.');

    }

    public function deleteDisposal($id){

           $disposal= Disposal::where('id',$id)->first();
           $item= Item::where('id',$disposal->item_id)->first();
            $item->quantity = $item->quantity + $disposal->quantity;
            $item->update();
            $disposal->delete();

        return back()->with('success',' Disposal Deleted Successfully.');

    }
}
