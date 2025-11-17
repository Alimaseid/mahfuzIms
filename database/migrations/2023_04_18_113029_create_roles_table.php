<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name');
            $table->string('manage_user')->nullable();
            $table->string('manage_delete_user')->nullable();
            $table->string('manage_edit_user')->nullable();
            $table->string('manage_location')->nullable();
            $table->string('manage_edit_location')->nullable();
            $table->string('manage_delete_location')->nullable();
            $table->string('manage_item')->nullable();
            $table->string('manage_edit_item')->nullable();
            $table->string('manage_delete_item')->nullable();
            $table->string('set_item_price')->nullable();
            $table->string('manage_item_unit')->nullable();
            $table->string('manage_edit_itemUnit')->nullable();
            $table->string('manage_delete_itemUnit')->nullable();
            $table->string('manage_category')->nullable();
            $table->string('manage_edit_category')->nullable();
            $table->string('manage_delete_category')->nullable();
            $table->string('manage_shelf')->nullable();
            $table->string('manage_edit_shelf')->nullable();
            $table->string('manage_delete_shelf')->nullable();
            $table->string('manage_customer')->nullable();
            $table->string('manage_edit_customer')->nullable();
            $table->string('manage_delete_customer')->nullable();
            $table->string('manage_good_receiving')->nullable();
            $table->string('manage_edit_goodreceiving')->nullable();
            $table->string('manage_purchase_plan')->nullable();
            $table->string('manage_delete_purchasePlan')->nullable();
            $table->string('manage_delete_goodreceiving')->nullable();
            $table->string('manage_customer_history')->nullable();
            $table->string('manage_dailycustomerReport')->nullable();
            $table->string('manage_item_transfer')->nullable();
            $table->string('manage_itemTransfer_delete')->nullable();
            $table->string('manage_sales')->nullable();
            $table->string('manage_edit_sales')->nullable();
            $table->string('manage_delete_sales')->nullable();
            $table->string('manage_dailysalesReport')->nullable();
            $table->string('manage_disposal')->nullable();
            $table->string('manage_edit_disposal')->nullable();
            $table->string('manage_delete_disposal')->nullable();
            $table->string('manage_activity_log')->nullable();
            $table->string('approval')->nullable();
            $table->string('manage_shopTRansferReports')->nullable();
            $table->string('manage_storeTRansferReports')->nullable();
            $table->string('manage_stock_reports')->nullable();
            $table->string('manage_shopStock_reports')->nullable();
            $table->string('supper_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
