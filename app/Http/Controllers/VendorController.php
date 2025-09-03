<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\Models\PurchaseLedger;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::orderBy('name', 'ASC')->get();
        $vendor = Vendor::all();
        return view('pages.purchase.vendor')
        ->with('vendor',$vendor)
        ->with('vendors',$vendors);
    }

    public function addVendor(Request $request){
        Vendor::create([
            'name'  =>$request->name,
            'company_name'  =>$request->company_name,
            'email' =>$request->email,
            'phone' =>$request->phone,
            'city'  =>$request->city,
            'woreda'    =>$request->woreda,
            'kebele'    =>$request->kebele,
        ]);
      $vender =  Vendor::latest()->first();
        PurchaseLedger::create([
            'by' =>0,
            'to' => $vender->id,
            'purchase_order_id'=>0,
            'debit' => 0,
            'credit' => 0,
            'balance' =>0,
        ]);

        return back()->with('success','Vender Registration Succeed.');
    }

    public function editVendor(Request $request,$id){
        Vendor::where('id',$id)->update([
            'name'  =>$request->name,
            'company_name'  =>$request->company_name,
            'email' =>$request->email,
            'phone' =>$request->phone,
            'city'  =>$request->city,
            'woreda'    =>$request->woreda,
            'kebele'    =>$request->kebele,
        ]);

        return back()->with('success','Vender Registration Succeed.');
    }

    public function searchVendor(Request $request){
        $customers = Vendor::Where('name','like','%'. $request->name.'%')
        ->orWhere('phone','like','%'. $request->name.'%')
        // ->orWhere('tin','like','%'. $request->name.'%')
        ->get();
        return json_encode($customers);
     }

     public function deleteVendor($id){
        Vendor::where('id',$id)->delete();
        return back()->with('success',' Item Deleted Successfully.');

    }
}
