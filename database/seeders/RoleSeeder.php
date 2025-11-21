<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'role_name' => 'Super Admin',

            'manage_user' => 'on',
            'manage_edit_user' => 'on',
            'manage_delete_user' => 'on',

            'manage_item' => 'on',
            'manage_edit_item' => 'on',
            'manage_delete_item' => 'on',
            'set_item_price' => 'on',

            'manage_location' => 'on',
            'manage_edit_location' => 'on',
            'manage_delete_location' => 'on',

            'manage_item_unit' => 'on',
            'manage_edit_itemUnit' => 'on',
            'manage_delete_itemUnit' => 'on',

            'manage_category' => 'on',
            'manage_edit_category' => 'on',
            'manage_delete_category' => 'on',

            'manage_shelf' => 'on',
            'manage_edit_shelf' => 'on',
            'manage_delete_shelf' => 'on',

            'manage_customer' => 'on',
            'manage_edit_customer' => 'on',
            'manage_delete_customer' => 'on',
            'manage_customer_history' => 'on',
            'manage_dailycustomerReport' => 'on',

            'manage_good_receiving' => 'on',
            'manage_edit_goodreceiving' => 'on',
            'manage_delete_goodreceiving' => 'on',

            'manage_purchase_plan' => 'on',
            'manage_delete_purchasePlan' => 'on',

            'manage_item_transfer' => 'on',
            'manage_itemTransfer_delete' => 'on',


            'manage_sales' => 'on',
            'manage_edit_sales' => 'on',
            'manage_delete_sales' => 'on',
            'manage_dailysalesReport' => 'on',
            'manage_shopStock_reports' => 'on',
            'manage_shopTRansferReports' => 'on',

            'manage_disposal' => 'on',
            'manage_edit_disposal' => 'on',
            'manage_delete_disposal' => 'on',

            'manage_activity_log' => 'on',
            'approval' => 'on',


            'manage_stock_reports' => 'on',
            'manage_storeTRansferReports' => 'on',
            'manage_notification' => 'on',

            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
