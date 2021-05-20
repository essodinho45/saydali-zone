<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('properties')->nullable();
            $table->string('package')->nullable();
            $table->string('storage')->nullable();
            $table->string('extra')->nullable();
            $table->string('extra2')->nullable();
            $table->string('properties_en')->nullable();
            $table->string('package_en')->nullable();
            $table->string('storage_en')->nullable();
            $table->string('extra_en')->nullable();
            $table->string('extra2_en')->nullable();
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
            $table->dropColumn('properties');
            $table->dropColumn('package');
            $table->dropColumn('storage');
            $table->dropColumn('extra');
            $table->dropColumn('extra2');
            $table->dropColumn('properties_en');
            $table->dropColumn('package_en');
            $table->dropColumn('storage_en');
            $table->dropColumn('extra_en');
            $table->dropColumn('extra2_en');
        });
    }
}
