<?php

namespace App\Http\Controllers;

use App\Models\ShopSales;
use App\Http\Requests\StoreShopSalesRequest;
use App\Http\Requests\UpdateShopSalesRequest;

class ShopSalesController extends Controller
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
     * @param  \App\Http\Requests\StoreShopSalesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShopSalesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopSales  $shopSales
     * @return \Illuminate\Http\Response
     */
    public function show(ShopSales $shopSales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopSales  $shopSales
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopSales $shopSales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateShopSalesRequest  $request
     * @param  \App\Models\ShopSales  $shopSales
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShopSalesRequest $request, ShopSales $shopSales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShopSales  $shopSales
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopSales $shopSales)
    {
        //
    }
}
