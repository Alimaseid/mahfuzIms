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
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('request_from');
            $table->string('request_by');
            $table->foreignId('transfer_from_store')->nullable();
            $table->foreignId('transfer_from_owner')->nullable();
            $table->string('transfer_by')->nullable();
            $table->string('issued_by')->nullable();
            $table->string('ship_by')->nullable();
            $table->string('status')->default('Pending');
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
        Schema::dropIfExists('requisitions');
    }
};
