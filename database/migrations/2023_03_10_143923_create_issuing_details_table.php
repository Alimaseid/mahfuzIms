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
        Schema::create('issuing_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issuing_id');
            $table->foreignId('item_id');
            $table->string('item_name');
            $table->string('qauntity');
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
        Schema::dropIfExists('issuing_details');
    }
};
