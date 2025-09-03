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
        Schema::create('item_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('transfer_from');
            $table->string('transfer_to');
            $table->string('quantity');
            $table->foreignId('transfer_by');
            $table->string('shipped_by');
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
        Schema::dropIfExists('item_transfers');
    }
};
