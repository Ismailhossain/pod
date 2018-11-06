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
//            $table->bigInteger('id')->unsigned();
            $table->Increments('id')->unsigned();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->char('status')->default(0)->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->text('login_token')->nullable();
            $table->text('register_token')->nullable();
            $table->dateTime('effective_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->dateTime('last_logged_in_at')->nullable();
            $table->dateTime('current_login_at')->nullable();
            $table->string('last_login_ip', 100)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

//            $table->primary('id','PK_users');

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
