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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('category');
            $table->string('shelf')->nullable();
            $table->string('unit')->nullable();
            $table->string('other_unit')->nullable();
            $table->string('quantity')->nullable();
            $table->string('product_code')->nullable();
            $table->string('part_number')->nullable();
            $table->string('item_code')->unique()->nullable();
            $table->string('bar_code')->nullable();
            $table->string('brand')->nullable();
            $table->string('cost_price')->nullable();
            $table->string('selling_price1')->nullable();
            $table->string('selling_price2')->nullable();
            $table->string('image')->nullable();
            $table->text('image2')->nullable();
            $table->string('status')->nullable();
            $table->text('description')->nullable();
            $table->integer('reorder')->nullable();
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
        Schema::dropIfExists('items');
    }
};
