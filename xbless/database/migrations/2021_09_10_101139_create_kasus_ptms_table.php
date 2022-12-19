<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasusPtmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kasus_ptm', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('puskesmas_id');
            $table->foreign('puskesmas_id')
                ->references('id')
                ->on('puskesmas')
                ->onDelete('cascade');
            $table->integer('ima');
            $table->integer('decomp_cordis');
            $table->integer('hipertensi');
            $table->integer('stroke');
            $table->integer('dm_tgt_insulin');
            $table->integer('dm_tak_tgt_insulin');
            $table->integer('ca_mammae');
            $table->integer('ca_serviks');
            $table->integer('leukimia');
            $table->integer('retiniblastoma');
            $table->integer('ca_kolorectal');
            $table->integer('talasemia');
            $table->integer('ppok');
            $table->integer('asma_bronkhiale');
            $table->integer('ginjal_kronik');
            $table->integer('osteoporosis');
            $table->integer('obesitas');
            $table->date('periode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kasus_ptm');
    }
}
