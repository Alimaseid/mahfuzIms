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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name');
            $table->boolean('manage_user')->default(false);
            $table->boolean('manage_item')->default(false);
            $table->boolean('manage_vendor')->default(false);
            $table->boolean('manage_purchase')->default(false);
            $table->boolean('manage_customer')->default(false);
            $table->boolean('manage_customer_history')->default(false);
            $table->boolean('manage_sales')->default(false);
            $table->boolean('manage_order')->default(false);
            $table->boolean('manage_store_issue')->default(false);
            $table->boolean('approval')->default(false);
            $table->boolean('reports')->default(false);
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
        Schema::dropIfExists('roles');
    }
};
