<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDdFrPtmKeswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dd_fr_ptm_keswa', function (Blueprint $table) {
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
            $table->integer('jml_hadir');
            $table->integer('jml_laki');
            $table->integer('jml_perempuan');
            $table->integer('usia_15_59');
            $table->integer('usia_59');
            $table->integer('cakupan_15_59');
            $table->integer('cakupan_59');
            $table->integer('sasaran_15_59');
            $table->integer('sasaran_59');
            $table->integer('diri_sendiri');
            $table->integer('keluarga');
            $table->integer('merokok');
            $table->integer('aktifitas_fisik');
            $table->integer('diet_tdk_seimbang');
            $table->integer('konsumsi_alkohol');
            $table->integer('td_tinggi');
            $table->integer('obesitas');
            $table->integer('lp_lebih');
            $table->integer('gds_tinggi');
            $table->integer('kolesterol_tinggi');
            $table->integer('asam_urat_tinggi');
            $table->integer('gangguan_penglihatan');
            $table->integer('gangguan_pendengaran');
            $table->integer('srw');
            $table->integer('kie');
            $table->integer('rujuk_fktp');
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
        Schema::dropIfExists('dd_fr_ptm_keswa');
    }
}
