<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;
use App\Models\BusinessLocation;
use App\Http\Requests\StoreBusinessLocationRequest;
use App\Http\Requests\UpdateBusinessLocationRequest;
use App\Models\ItemOnShop;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class BusinessLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $locations =  BusinessLocation::orderBy('id', 'desc')->paginate(200);
        $location =  BusinessLocation::all();
        $permission = Role::where('id', Auth::user()->role)->first();
        return view('pages.business_location.location')
            ->with('locations', $locations)
            ->with('permission', $permission)
            ->with('location', $location);
    }

    public function addLocation(Request $request)
    {

        $Data = $request->validate([
            'name' => ['required', 'unique:business_locations', 'max:255'],
            'type' => ['required'],
            // 'owner' => ['required'],
        ], [
            'name.unique' => 'This name already exists. Please choose another name.',
            'name.required' => 'name is required.',
        ]);
        $location = BusinessLocation::create([
            'name' => $request->name,
            'type' => $request->type,
            'site' => $request->site,
            'address' => $request->address

        ]);
        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($location)
            ->withProperties(['data' => $location])
            ->log('Added new business location');
        return back()->with('success', 'Location Added Successfully.');
    }

    public function editLocation(Request $request, $id)
    {

        $location = BusinessLocation::findOrFail($id);
        $location->update([
            'name' => $request->name,
            'type' => $request->type,
            'site' => $request->site,
            'address' => $request->address

        ]);
        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($location)
            ->withProperties(['data' => $location->toArray()])
            ->log('Edited a business location');
        return back()->with('success', ' Edit Location Successfully.');
    }

    public function deleteLocation($id)
    {
        $location = BusinessLocation::findOrFail($id);

        $location->delete();

        //  Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($location)
            ->withProperties(['data' => $location])
            ->log('Deleted a business location');

        return back()->with('success', ' Location Deleted Successfully.');
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

    public function itemsOnShop($id)
    {
        $items  = ItemOnShop::where('location_id', $id)->get();;
        return view('pages.store.items_on_shop')->with('items', $items);
    }
}
