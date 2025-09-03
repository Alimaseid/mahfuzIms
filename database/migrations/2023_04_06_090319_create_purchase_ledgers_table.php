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
        Schema::create('purchase_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('by');
            $table->foreignId('to');
            $table->foreignId('purchase_order_id')->nullable();
            $table->string('debit');
            $table->string('credit');
            $table->string('balance');
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
        Schema::dropIfExists('purchase_ledgers');
    }
};
