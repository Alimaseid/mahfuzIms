<?php

namespace App\Http\Controllers;

use App\Models\Item_on_Shop;
use App\Http\Requests\StoreItem_on_ShopRequest;
use App\Http\Requests\UpdateItem_on_ShopRequest;

class ItemOnShopController extends Controller
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
     * @param  \App\Http\Requests\StoreItem_on_ShopRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItem_on_ShopRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item_on_Shop  $item_on_Shop
     * @return \Illuminate\Http\Response
     */
    public function show(Item_on_Shop $item_on_Shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item_on_Shop  $item_on_Shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Item_on_Shop $item_on_Shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItem_on_ShopRequest  $request
     * @param  \App\Models\Item_on_Shop  $item_on_Shop
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItem_on_ShopRequest $request, Item_on_Shop $item_on_Shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item_on_Shop  $item_on_Shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item_on_Shop $item_on_Shop)
    {
        //
    }
}
