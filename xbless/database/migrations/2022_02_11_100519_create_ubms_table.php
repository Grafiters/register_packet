<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ubm', function (Blueprint $table) {
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
            $table->integer('jml_klien_berkunjung_baru');
            $table->integer('jml_klien_berkunjung_lama');
            $table->integer('jml_klien_berkunjung_total');
            $table->integer('car3');
            $table->integer('car6');
            $table->integer('car9');
            $table->integer('status_klien_rujuk');
            $table->integer('status_klien_kambuh');
            $table->integer('status_klien_drop');
            $table->integer('status_klien_sukses');
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
        Schema::dropIfExists('ubm');
    }
}
