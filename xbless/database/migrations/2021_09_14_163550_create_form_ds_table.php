<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_d', function (Blueprint $table) {
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
            $table->date('tgl');
            $table->string('no_registrasi');
            $table->string('nama');
            $table->string('umur');
            $table->string('alamat');
            $table->tinyInteger('lr_hasil_iva')->length(1)->default(0)->comment('0: Negatif; 1: Positif; 2:IVA Ragu-ragu');
            $table->tinyInteger('lr_dirujuk')->length(1)->default(0)->comment('0: Lesu luas; 1: Curiga CA; 2:IVA Kel Gyn');
            $table->string('p_normal');
            $table->tinyInteger('p_dirujuk')->length(1)->default(0)->comment('0: Benjolan; 1: Curiga CA; 2:lainnya');
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
        Schema::dropIfExists('form_d');
    }
}
