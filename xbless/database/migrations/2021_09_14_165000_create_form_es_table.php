<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormEsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_e', function (Blueprint $table) {
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
            $table->string('no_registrasi');
            $table->string('nama');
            $table->string('umur');
            $table->string('alamat');
            $table->date('tgl_iva');
            $table->enum('iva_ulang_krio', ['Positif', 'Negatif']);
            $table->tinyInteger('pelaksanaan_krio')->length(1)->default(0)->comment('0: Hari ini; 1: < 1 bulan; 2:> 1 bulan');
            $table->enum('ada_keluhan', ['Ya', 'Tidak']);
            $table->enum('iva_pasca_krio_6bln', ['Positif', 'Negatif']);
            $table->enum('iva_pasca_krio_1thn', ['Positif', 'Negatif']);
            $table->string('keterangan');
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
        Schema::dropIfExists('form_e');
    }
}
