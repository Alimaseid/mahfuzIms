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
        Schema::create('item_returns', function (Blueprint $table) {
            $table->id();
            $table->date('return_date')->nullable();
            $table->foreignId('sales_order_id');
            $table->foreignId('customer_id');
            $table->foreignId('return_by');
            $table->foreignId('return_to');
            $table->string('refunded_type');
            $table->string('refunded_amount')->nullable();
            $table->text('reason')->nullable();
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
        Schema::dropIfExists('item_returns');
    }
};
