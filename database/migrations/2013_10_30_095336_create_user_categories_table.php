<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->timestamps();
        });
        DB::table('user_categories')->insert(
            array(
            ['name' => 'Company'],
            ['name' => 'Agent'],
            ['name' => 'Distributor'],
            ['name' => 'Free Distributor'],
            ['name' => 'Pharmacist'],
            )
    );
    DB::table('user_categories')->insert(['id' => 0, 'name' => 'Administrator']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_categories');
    }
}
