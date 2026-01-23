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
        Schema::create('login_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->timestamp('attempted_at');
            $table->string('status'); // allowed / blocked
            $table->string('reason'); // policy / exception
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_audit_logs');
    }
};
