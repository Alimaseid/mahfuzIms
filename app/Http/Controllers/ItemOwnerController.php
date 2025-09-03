<?php

namespace App\Http\Controllers;

use App\Models\ItemOwner;
use App\Http\Requests\StoreItemOwnerRequest;
use App\Http\Requests\UpdateItemOwnerRequest;

class ItemOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreItemOwnerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemOwnerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemOwner  $itemOwner
     * @return \Illuminate\Http\Response
     */
    public function show(ItemOwner $itemOwner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemOwner  $itemOwner
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemOwner $itemOwner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemOwnerRequest  $request
     * @param  \App\Models\ItemOwner  $itemOwner
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemOwnerRequest $request, ItemOwner $itemOwner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemOwner  $itemOwner
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemOwner $itemOwner)
    {
        //
    }
}
