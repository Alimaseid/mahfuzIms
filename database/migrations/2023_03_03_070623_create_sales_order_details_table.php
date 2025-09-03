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
        Schema::create('sales_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id');
            $table->foreignId('location_id');
            $table->foreignId('owner_id');
            $table->string('item_name');
            $table->integer('quantity');
            $table->string('tax')->nullable();
            $table->string('amount');
            $table->string('total');
            $table->string('sales_order_id');
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
        Schema::dropIfExists('sales_order_details');
    }
};
