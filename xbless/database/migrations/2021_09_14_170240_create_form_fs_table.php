<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_f', function (Blueprint $table) {
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
            $table->tinyInteger('leher_rahim')->length(1)->default(0)->comment('0: Konfirmasi iva +; 1: Lesi pra kanker luas; 2:Curiga kanker leher rahim; 3:Kel Gyn lain ');
            $table->tinyInteger('payudara')->length(1)->default(0)->comment('0: Benjolan payudara; 1: Curiga kanker payudara; 2:lain-lain');
            $table->enum('kolposkopi', ['Positif', 'Negatif']);
            $table->string('benar_kanker_leher_rahim');
            $table->string('benar_kanker_leher_payudara');
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
        Schema::dropIfExists('form_f');
    }
}
