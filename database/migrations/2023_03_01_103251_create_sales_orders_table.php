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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->string('reference_number')->nullable();
            $table->string('sales_person')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('sales_type')->nullable();
            $table->foreignId('location_id')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('SM_status')->default('Pending');
            $table->string('r_status')->default('Pending');
            $table->text('rejectReasone')->nullable();
            $table->string('vat')->nullable();
            $table->string('discount')->nullable();
            $table->string('with_holding')->nullable();
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
        Schema::dropIfExists('sales_orders');
    }
};
