<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpwlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipwl', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')
            //     ->references('id')
            //     ->on('users')
            //     ->onDelete('cascade');
            // $table->unsignedBigInteger('kabupaten_id');
            // $table->foreign('kabupaten_id')
            //     ->references('id')
            //     ->on('kabupaten')
            //     ->onDelete('cascade');
            // $table->string('nama');
            // $table->string('alamat');
            // $table->date('periode');
            $table->string('code');
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('provinsi');
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
        Schema::dropIfExists('ipwl');
    }
}
