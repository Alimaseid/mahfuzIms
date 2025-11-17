<?php

namespace App\Providers;

use App\Models\Item;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(200);

        View::composer('*', function ($view) {
            $lowStockItems = \App\Models\Inventory::with(['item', 'location'])
                ->whereHas('item', function ($query) {
                    $query->whereColumn('inventories.quantity', '<', 'items.reorder');
                })
                ->whereHas('location', function ($query) {
                    $query->where('type', 'Warehouse');
                })
                ->get();

            $view->with('lowStockItems', $lowStockItems);
        });
        View::composer('*', function ($view) {
            $lowShopItems = \App\Models\Inventory::with(['item', 'location'])
                ->whereHas('item', function ($query) {
                    $query->whereColumn('inventories.quantity', '<', 'items.reorder_for_shop');
                })
                ->whereHas('location', function ($query) {
                    $query->where('type', 'Shop');
                })
                ->get();

            $view->with('lowShopItems', $lowShopItems);
        });
    }
}
