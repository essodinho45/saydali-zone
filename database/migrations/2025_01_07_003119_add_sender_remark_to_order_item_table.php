<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSenderRemarkToOrderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_item', function (Blueprint $table) {
            $table->string('sender_remark')->nullable()->default(null);
            $table->string('reciever_remark')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_item', function (Blueprint $table) {
            if (Schema::hasColumn('order_item', 'reciever_remark')) {
                $table->dropColumn('reciever_remark');
            }
            if (Schema::hasColumn('order_item', 'sender_remark')) {
                $table->dropColumn('sender_remark');
            }
        });
    }
}
