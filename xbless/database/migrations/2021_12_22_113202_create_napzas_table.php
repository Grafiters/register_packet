<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNapzasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('napza', function (Blueprint $table) {
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
            $table->string('iwpl');
            $table->integer('jml_rujukan_assist');
            $table->integer('jml_non_rujukan');
            $table->integer('jml_rahap_pembantaran');
            $table->integer('jml_rahap_pidana');
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
        Schema::dropIfExists('napza');
    }
}
