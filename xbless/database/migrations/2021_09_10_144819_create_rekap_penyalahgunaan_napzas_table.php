<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapPenyalahgunaanNapzasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_penyalahgunaan_napza', function (Blueprint $table) {
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
            $table->integer('rujukan_assist');
            $table->integer('non_rujukan');
            $table->integer('rehap_pembataran');
            $table->integer('rehab_pidana');
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
        Schema::dropIfExists('rekap_penyalahgunaan_napza');
    }
}
