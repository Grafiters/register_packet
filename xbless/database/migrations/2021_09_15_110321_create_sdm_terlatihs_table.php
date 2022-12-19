<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSdmTerlatihsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sdm_terlatih', function (Blueprint $table) {
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
            $table->integer('pandu_pelatihan');
            $table->integer('pandu_ojt');
            $table->integer('posbindu_kader');
            $table->integer('posbindu_kit');
            $table->integer('posbindu_ojt');
            $table->integer('iva_sadanis_dokter');
            $table->integer('iva_sadanis_bidan');
            $table->integer('iva_sadanis_jml_alat_krio');
            // $table->integer('iva_sadanis_ojt');
            $table->integer('ubm_tenaga');
            $table->integer('ubm_spirometri');
            $table->integer('ubm_ojt');
            $table->integer('indera_pelatihan');
            $table->integer('indera_ojt');
            $table->integer('keswa_pelatihan');
            $table->integer('keswa_sdq');
            $table->integer('keswa_srq');
            $table->integer('keswa_jiwa');
            $table->integer('keswa_ojt');
            $table->integer('assist_pelatihan');
            $table->integer('assist_ojt');
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
        Schema::dropIfExists('sdm_terlatih');
    }
}
