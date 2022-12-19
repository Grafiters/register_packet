<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSdqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sdq', function (Blueprint $table) {
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
            $table->integer('dd_sdq_4_10_l');
            $table->integer('dd_sdq_4_10_p');
            $table->integer('dd_sdq_11_18_l');
            $table->integer('dd_sdq_11_18_p');
            $table->integer('abnormal_4_10_l');
            $table->integer('abnormal_4_10_p');
            $table->integer('abnormal_11_18_l');
            $table->integer('abnormal_11_18_P');
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
        Schema::dropIfExists('sdq');
    }
}
