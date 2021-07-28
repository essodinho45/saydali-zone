<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistsCompsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dists_comps', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('dist_id');
            $table->unsignedBigInteger('comp_id');
            $table->timestamps();

            $table->unique(['dist_id','comp_id']);

            $table->foreign('dist_id')->references('id')->on('users');
            $table->foreign('comp_id')->references('id')->on('users');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dists_comps');
    }
}
