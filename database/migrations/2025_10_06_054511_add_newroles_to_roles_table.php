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
            $table->string('manage_user')->nullable();
            $table->string('manage_delete_user')->nullable();
            $table->string('manage_location')->nullable();
            $table->string('manage_item')->nullable();
            $table->string('manage_delete_item')->nullable();
            $table->string('set_item_price')->nullable();
            $table->string('manage_item_unit')->nullable();
            $table->string('manage_category')->nullable();
            $table->string('manage_shelf')->nullable();
            $table->string('manage_customer')->nullable();
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
