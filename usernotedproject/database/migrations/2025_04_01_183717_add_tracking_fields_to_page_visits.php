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
        Schema::table('page_visits', function (Blueprint $table) {
            $table->string('ip_addressh')->nullable();
            $table->string('region')->nullable();
            $table->string('country_name')->nullable();
            $table->string('country_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('state_name')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('timezone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_visits', function (Blueprint $table) {
            $table->dropColumn([
                'ip_address', 'region', 'country_name', 'country_code',
                'latitude', 'longitude', 'state_name', 'zip_code', 'city', 'timezone'
            ]);
        });
    }
};
