<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assist', function (Blueprint $table) {
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
            $table->integer('jml_sklh_skrining_assist');
            $table->integer('jml_peserta_pusk_l');
            $table->integer('jml_peserta_pusk_p');
            $table->integer('jml_peserta_sklh_l');
            $table->integer('jml_peserta_sklh_p');
            $table->integer('tembakau_l');
            $table->integer('tembakau_p');
            $table->integer('alkohol_l');
            $table->integer('alkohol_p');
            $table->integer('kanabis_l');
            $table->integer('kanabis_P');
            $table->integer('kokain_l');
            $table->integer('kokain_p');
            $table->integer('stimulan_l');
            $table->integer('stimulan_p');
            $table->integer('inhalansia_l');
            $table->integer('inhalansia_p');
            $table->integer('sedatif_l');
            $table->integer('sedatif_p');
            $table->integer('halusinogen_l');
            $table->integer('halusinogen_p');
            $table->integer('opioida_l');
            $table->integer('opioida_p');
            $table->integer('lain_l');
            $table->integer('lain_p');
            $table->integer('skrining_ringan_l');
            $table->integer('skrining_ringan_p');
            $table->integer('skrining_sedang_l');
            $table->integer('skrining_sedang_p');
            $table->integer('skrining_berat_l');
            $table->integer('skrining_berat_p');
            $table->integer('tindak_skrining_rujuk_l');
            $table->integer('tindak_skrining_rujuk_p');
            $table->integer('tindak_skrining_langsung_l');
            $table->integer('tindak_skrining_langsung_P');
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
        Schema::dropIfExists('assist');
    }
}
