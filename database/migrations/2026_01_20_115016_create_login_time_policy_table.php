<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_time_policy', function (Blueprint $table) {
            $table->id('policy_id'); // SERIAL equivalent
            $table->time('start_time');
            $table->time('end_time');
            $table->string('timezone', 50)->default('Africa/Addis_Ababa');
            $table->boolean('active')->default(true);
            $table->foreignId('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_time_policy');
    }
};
