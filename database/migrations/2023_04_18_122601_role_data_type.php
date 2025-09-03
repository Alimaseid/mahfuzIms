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
        Schema::table('roles', function (Blueprint $table) {
            //
            $table->String('manage_user')->nullable()->change();
            $table->String('manage_item')->nullable()->change();
            $table->String('manage_vendor')->nullable()->change();
            $table->String('manage_purchase')->nullable()->change();
            $table->String('manage_customer')->nullable()->change();
            $table->String('manage_customer_history')->nullable()->change();
            $table->String('manage_sales')->nullable()->change();
            $table->String('manage_order')->nullable()->change();
            $table->String('manage_store_issue')->nullable()->change();
            $table->String('approval')->nullable()->change();
            $table->String('reports')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            //
        });
    }
};
