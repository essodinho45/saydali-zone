<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('item_category_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('composition')->nullable();
            $table->string('dosage')->nullable();
            $table->string('descr1')->nullable();
            $table->string('descr2')->nullable();
            $table->float('price');            
            $table->float('customer_price');
            $table->float('titer');
            $table->unsignedBigInteger('item_type_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('item_category_id')->references('id')->on('item_categories');
            $table->foreign('item_type_id')->references('id')->on('item_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
