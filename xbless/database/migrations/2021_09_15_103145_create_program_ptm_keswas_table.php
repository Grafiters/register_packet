<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramPtmKeswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_ptm_keswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('kabupaten_id');
            $table->foreign('kabupaten_id')
                ->references('id')
                ->on('kabupaten')
                ->onDelete('cascade');
            $table->integer('jml_desa');
            $table->integer('umum');
            $table->integer('sekolah');
            $table->integer('institusi');
            $table->integer('perusahaan');
            $table->integer('kelompok_lain');
            $table->integer('jml_desa_posbindu');
            $table->integer('pusk_layanan_iva');
            $table->integer('pusk_layanan_krio');
            $table->integer('ubm');
            $table->integer('dd_indera');
            $table->integer('dd_gangguan_jiwa');
            $table->integer('pusk_assist');
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
        Schema::dropIfExists('program_ptm_keswa');
    }
}
