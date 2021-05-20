<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baskets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->integer('price');
            $table->timestamps();            

            $table->foreign('user_id')->references('id')->on('users');

        });
        Schema::create('basket_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('basket_id');
            $table->unsignedBigInteger('item_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->unique(['basket_id','item_id']);

            $table->foreign('basket_id')->references('id')->on('baskets');
            $table->foreign('item_id')->references('id')->on('items');
        });
        Schema::create('basket_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('basket_id');
            $table->unsignedBigInteger('order_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->unique(['basket_id','order_id']);

            $table->foreign('basket_id')->references('id')->on('baskets');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basket_item');
        Schema::dropIfExists('basket_order');
        Schema::dropIfExists('baskets');
    }
}
