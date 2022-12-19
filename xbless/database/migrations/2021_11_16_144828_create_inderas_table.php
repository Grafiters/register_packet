<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInderasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indera', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('puskesmas_id');
            $table->string('kegiatan');
            $table->integer('umur_0_7hr_l')->default(0)->nullable();
            $table->integer('umur_0_7hr_p')->default(0)->nullable();
            $table->integer('umur_2_28hr_l')->default(0)->nullable();
            $table->integer('umur_2_28hr_p')->default(0)->nullable();
            $table->integer('umur_1_11bln_l')->default(0)->nullable();
            $table->integer('umur_1_11bln_p')->default(0)->nullable();
            $table->integer('umur_1_4thn_l')->default(0)->nullable();
            $table->integer('umur_1_4thn_p')->default(0)->nullable();
            $table->integer('umur_5_9thn_l')->default(0)->nullable();
            $table->integer('umur_5_9thn_p')->default(0)->nullable();
            $table->integer('umur_10_14thn_l')->default(0)->nullable();
            $table->integer('umur_10_14thn_p')->default(0)->nullable();
            $table->integer('umur_15_19thn_l')->default(0)->nullable();
            $table->integer('umur_15_19thn_p')->default(0)->nullable();
            $table->integer('umur_20_44thn_l')->default(0)->nullable();
            $table->integer('umur_20_44thn_p')->default(0)->nullable();
            $table->integer('umur_45_59thn_l')->default(0)->nullable();
            $table->integer('umur_45_59thn_p')->default(0)->nullable();
            $table->integer('umur_lebih_59thn_l')->default(0)->nullable();
            $table->integer('umur_lebih_59thn_p')->default(0)->nullable();
            $table->integer('kasus_baru_l')->default(0)->nullable();
            $table->integer('kasus_baru_p')->default(0)->nullable();
            $table->integer('kasus_lama_l')->default(0)->nullable();
            $table->integer('kasus_lama_p')->default(0)->nullable();
            $table->integer('kunjungan_l')->default(0)->nullable();
            $table->integer('kunjungan_p')->default(0)->nullable();
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
        Schema::dropIfExists('indera');
    }
}
