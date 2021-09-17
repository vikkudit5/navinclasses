<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id');
            $table->integer('role_id');
            $table->string('ip_address');
            $table->string('username');
            $table->string('email');
            $table->string('phone');
            $table->string('institute');
            $table->string('password');
            $table->string('profile_pics');
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
        Schema::dropIfExists('admin__users');
    }
}
