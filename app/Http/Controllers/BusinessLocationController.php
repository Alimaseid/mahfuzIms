<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;
use App\Models\BusinessLocation;
use App\Http\Requests\StoreBusinessLocationRequest;
use App\Http\Requests\UpdateBusinessLocationRequest;
use App\Models\ItemOnShop;

class BusinessLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       $locations =  BusinessLocation::orderBy('id', 'desc')->get();
       $location =  BusinessLocation::all();
       $owners =  Owner::orderBy('id', 'desc')->get();

       return view('pages.business_location.location')
       ->with('owners', $owners)
       ->with('locations', $locations)
       ->with('location', $location);
    }

    public function addLocation(Request $request){
        $Data = $request->validate([
            'name' => ['required', 'unique:business_locations', 'max:255'],
            'type' => ['required'],
            // 'owner' => ['required'],
        ]);
       BusinessLocation::create([
            'name'=>$request->name,
            'type'=>$request->type,
            'site'=>$request->site,
            'owner_id'=>'Null',
            'address'=>$request->address

        ]);
        return back()->with('success','Location Added Successfully.');

    }

    public function editLocation(Request $request,$id){

        BusinessLocation::where('id',$id)->update([
            'name'=>$request->name,
            'type'=>$request->type,
            'owner_id'=>'Null',
            'site'=>$request->site,
            'address'=>$request->address

        ]);
        return back()->with('success',' Edit Location Successfully.');

    }

    public function deleteLocation($id){
        BusinessLocation::where('id',$id)->delete();
        return back()->with('success',' Location Deleted Successfully.');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBusinessLocationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBusinessLocationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BusinessLocation  $businessLocation
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessLocation $businessLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BusinessLocation  $businessLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessLocation $businessLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBusinessLocationRequest  $request
     * @param  \App\Models\BusinessLocation  $businessLocation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBusinessLocationRequest $request, BusinessLocation $businessLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BusinessLocation  $businessLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessLocation $businessLocation)
    {
        //
    }

    public function itemsOnShop($id){
        $items  = ItemOnShop::where('location_id', $id)->get();;
        return view('pages.store.items_on_shop')->with('items', $items);
    }
}
