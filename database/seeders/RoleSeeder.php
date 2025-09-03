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
            'manage_item' => 'on',
            'manage_vendor' => 'on',
            'manage_purchase' => 'on',
            'manage_customer' => 'on',
            'manage_customer_history' => 'on',
            'manage_sales' => 'on',
            'manage_order' => 'on',
            'manage_store_issue' => 'on',
            'approval' => 'on',
            'reports' => 'on',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
