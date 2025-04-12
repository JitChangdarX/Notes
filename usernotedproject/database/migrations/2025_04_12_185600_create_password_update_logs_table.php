<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordUpdateLogsTable extends Migration
{
    public function up()
    {
        Schema::create('password_update_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('email');
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('signup_account')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('password_update_logs');
    }
}
