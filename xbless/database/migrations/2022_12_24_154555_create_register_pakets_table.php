<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterPaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_pakets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_paket_id');
            $table->foreign('detail_paket_id')->references('id')->on('detail_pakets')->onDelete('cascade');
            $table->string('nik');
            $table->string('name');
            $table->string('address');
            $table->string('usaha')->nullable();
            $table->string('email');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }
    // Foto KTP / SIM
    // Foto KK
    // Foto selfie pegang ktp / SIM
    // Foto lokasi tampak depan
    // Foto usaha (jika ada)
    // Foto NIB / sku / siup (jika ada)

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('register_pakets');
    }
}
