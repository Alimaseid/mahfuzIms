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
    public function up(): void
    {
        Schema::rename('login_time_policy', 'login_time_policies');
    }

    public function down(): void
    {
        Schema::rename('login_time_policies', 'login_time_policy');
    }
};
