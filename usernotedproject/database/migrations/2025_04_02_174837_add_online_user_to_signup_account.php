<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('signup_account', function (Blueprint $table) {
            $table->boolean('online_user')->default(false)->after('id'); // Add the new column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('signup_account', function (Blueprint $table) {
            $table->dropColumn('online_user'); // Rollback if needed
        });
    }
};
