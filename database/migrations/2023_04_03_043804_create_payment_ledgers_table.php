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
        Schema::create('payment_ledgers', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('customer_id');
            $table->text('narration')->nullable();
            $table->string('voucher_no')->nullable();
            $table->string('voucher_type')->nullable();
            $table->string('refrence_no')->nullable();
            $table->string('debit');
            $table->string('credit');
            $table->string('running_balance');
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
        Schema::dropIfExists('payment_ledgers');
    }
};
