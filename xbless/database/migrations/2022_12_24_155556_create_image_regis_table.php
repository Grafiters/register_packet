<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageRegisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_regis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('register_paket_id');
            $table->foreign('register_paket_id')->references('id')->on('register_pakets')->onDelete('cascade');
            $table->string('name');
            $table->string('img');
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
        Schema::dropIfExists('image_regis');
    }
}
