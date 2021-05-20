<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('f_name');
            $table->string('s_name')->nullable();
            $table->unsignedBigInteger('country');
            $table->unsignedBigInteger('user_category_id');
            $table->unsignedBigInteger('city');
            $table->string('region')->nullable();
            $table->string('address')->nullable();
            $table->integer('tel1')->nullable();
            $table->integer('tel2')->nullable();
            $table->integer('mob1')->nullable();
            $table->integer('mob2')->nullable();
            $table->string('website')->nullable();
            $table->string('email2')->nullable();
            $table->string('logo_image')->nullable();
            $table->integer('licence_number')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('user_category_id')->references('id')->on('user_categories');
            $table->foreign('country')->references('id')->on('countries');
            $table->foreign('city')->references('id')->on('cities');
        });
        Schema::create('user_relations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('child_id');
            $table->unsignedBigInteger('parent_id');
            $table->timestamps();

            $table->unique(['child_id','parent_id']);

            $table->foreign('child_id')->references('id')->on('users');
            $table->foreign('parent_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_relations');
        Schema::dropIfExists('users');
    }
}
