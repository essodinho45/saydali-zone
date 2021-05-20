<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('name_en')->nullable();
            $table->string('composition_en')->nullable();
            $table->string('dosage_en')->nullable();
            $table->string('descr1_en')->nullable();
            $table->string('descr2_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('name_en');
            $table->dropColumn('composition_en');
            $table->dropColumn('dosage_en');
            $table->dropColumn('descr1_en');
            $table->dropColumn('descr2_en');
            //
        });
    }
}
