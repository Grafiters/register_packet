<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpmProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spm_program', function (Blueprint $table) {
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
            $table->integer('dd_fr_ptm_sas');
            $table->integer('dd_fr_ptm_real');
            $table->integer('dd_penglihatan_pendengaran_sas');
            $table->integer('dd_penglihatan_pendengaran_real');
            $table->integer('layanan_posbindu_ptm_sas');
            $table->integer('layanan_posbindu_ptm_real');
            $table->integer('dd_ca_payudara_ca_servik_sas');
            $table->integer('dd_ca_payudara_ca_servik_real');
            $table->integer('yankes_napza_sas');
            $table->integer('yankes_napza_real');
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
        Schema::dropIfExists('spm_program');
    }
}
