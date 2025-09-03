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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vender')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('shipment_reference')->nullable();
            $table->string('business_location');
            $table->string('owner');
            $table->string('payment_terms');
            $table->string('check_no')->nullable();
            $table->string('account_number')->nullable();
            $table->date('expected_delivery_date')->nullable();
            $table->date('total_payment')->nullable();
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
        Schema::dropIfExists('purchase_orders');
    }
};
