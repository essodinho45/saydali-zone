<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ar_name')->unique()->nullable();
            $table->string('en_name')->unique()->nullable();
            $table->timestamps();
        });
        DB::table('countries')->insert(
            array(
            ['ar_name'=>'سوريا', 'en_name'=>'Syria'],
            ['ar_name'=>'لبنان', 'en_name'=>'Lebanon'],
            ['ar_name'=>'الأردن', 'en_name'=>'Jordan'],
            ['ar_name'=>'السعودية', 'en_name'=>'Saudi Arabia'],
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
        Schema::dropIfExists('countries');
    }
}
