<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToDetailPaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_pakets', function (Blueprint $table) {
            $table->tinyInteger('status')->length(1)->default(0)->comment('0: Tidak Aktif; 1: Aktif')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_pakets', function (Blueprint $table) {
            //
        });
    }
}
