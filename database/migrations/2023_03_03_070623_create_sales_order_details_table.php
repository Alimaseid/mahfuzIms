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
            $table->foreignId('batch_id');
            $table->foreignId('sales_order_id');
            $table->string('item_name');
            $table->integer('quantity');
            $table->integer('remaining')->nullable();
            $table->string('tax')->nullable();
            $table->string('with_holding')->nullable();
            $table->string('amount');
            $table->string('total');
            $table->string('status')->default('Pending');
            $table->string('discount')->nullable();
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
