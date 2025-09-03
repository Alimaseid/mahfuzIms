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
        Schema::create('issuings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_Id');
            $table->foreignId('issued_from');
            $table->foreignId('issued_to');
            $table->string('voucher_number');
            $table->date('date');
            $table->foreignId('issued_by');
            $table->foreignId('issuing_detail_id');
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
        Schema::dropIfExists('issuings');
    }
};
