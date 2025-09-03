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
        Schema::create('purchse_payments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('amount');
            $table->string('discount')->nullable();
            $table->string('refrence_no')->nullable();
            $table->string('payment_type');
            $table->string('BankName')->nullable();
            $table->string('Docs')->nullable();
            $table->text('Remarks')->nullable();
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
        Schema::dropIfExists('purchse_payments');
    }
};
