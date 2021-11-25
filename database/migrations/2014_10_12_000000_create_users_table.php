<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname','150');
            $table->string('secondname','100')->nullable();
            $table->string('username','100')->nullable();
            $table->string('email')->unique();
            $table->string('verification_code','200')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('accountstatus');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
