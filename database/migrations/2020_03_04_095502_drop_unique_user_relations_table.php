<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUniqueUserRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('user_relations', function (Blueprint $table) {
            //
            $table->dropForeign('user_relations_child_id_foreign');
            $table->dropUnique('user_relations_child_id_parent_id_unique');
            $table->unique(['child_id', 'parent_id', 'comp_id']);
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('user_relations', function (Blueprint $table) {
            //
            $table->dropUnique('user_relations_child_id_parent_id_comp_id_unique');
        });
        Schema::enableForeignKeyConstraints();
    }
}
