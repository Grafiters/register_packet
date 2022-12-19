<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemografisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demografi', function (Blueprint $table) {
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
            $table->integer('umur_0_4_l');
            $table->integer('umur_0_4_p');
            $table->integer('umur_5_9_l');
            $table->integer('umur_5_9_p');
            $table->integer('umur_10_14_l');
            $table->integer('umur_10_14_p');
            $table->integer('umur_15_19_l');
            $table->integer('umur_15_19_p');
            $table->integer('umur_20_24_l');
            $table->integer('umur_20_24_p');
            $table->integer('umur_25_29_l');
            $table->integer('umur_25_29_p');
            $table->integer('umur_30_34_l');
            $table->integer('umur_30_34_p');
            $table->integer('umur_35_39_l');
            $table->integer('umur_35_39_p');
            $table->integer('umur_40_44_l');
            $table->integer('umur_40_44_p');
            $table->integer('umur_45_49_l');
            $table->integer('umur_45_49_p');
            $table->integer('umur_50_54_l');
            $table->integer('umur_50_54_p');
            $table->integer('umur_55_59_l');
            $table->integer('umur_55_59_p');
            $table->integer('umur_60_64_l');
            $table->integer('umur_60_64_p');
            $table->integer('umur_65_l');
            $table->integer('umur_65_p');
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
        Schema::dropIfExists('demografi');
    }
}
