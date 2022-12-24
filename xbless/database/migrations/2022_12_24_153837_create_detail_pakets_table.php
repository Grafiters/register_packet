<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pakets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paket_id');
            $table->foreign('paket_id')->references('id')->on('pakets')->onDelete('cascade');
            $table->unsignedBigInteger('speed_id');
            $table->foreign('speed_id')->references('id')->on('speeds')->onDelete('cascade');
            $table->double('price');
            $table->text('description');
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
        Schema::dropIfExists('detail_pakets');
    }
}
