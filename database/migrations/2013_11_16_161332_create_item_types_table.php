<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique()->nullable();
            $table->string('ar_name')->unique()->nullable();
            $table->timestamps();
        });
        DB::table('item_types')->insert(
            array(
            ['ar_name' => 'امبول'],
            ['ar_name' => 'فيال'],
            ['ar_name' => 'حب'],
            ['ar_name' => 'كبسول'],
            ['ar_name' => 'شراب'],
            ['ar_name' => 'شراب معلق'],
            ['ar_name' => 'محلول'],
            ['ar_name' => 'بودرة'],
            ['ar_name' => 'كريم'],
            ['ar_name' => 'مرهم'],
            )
    );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_types');
    }
}
