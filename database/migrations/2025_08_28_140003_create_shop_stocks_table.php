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
        Schema::create('shop_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('quantity')->nullable();
            $table->string('product_code')->nullable();
            $table->string('part_number')->nullable();
            $table->string('bar_code')->nullable();
            $table->string('location_name')->nullable();
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
        Schema::dropIfExists('shop_stocks');
    }
};
