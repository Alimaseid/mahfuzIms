<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_time_exceptions', function (Blueprint $table) {
            $table->id('exception_id');
            $table->foreignId('user_id')
                ->nullable();

            // ✅ CHANGE TIMESTAMP → DATETIME
            $table->dateTime('allowed_from');
            $table->dateTime('allowed_to');

            $table->text('reason')->nullable();

            $table->foreignId('created_by')
                ->nullable();

            $table->boolean('active')->default(true);

            // ✅ Use datetime, not timestamp
            $table->dateTime('created_at')->useCurrent();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('login_time_exceptions');
    }
};
