<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapGangguanJiwasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_gangguan_jiwa', function (Blueprint $table) {
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
            $table->integer('demensia_l');
            $table->integer('demensia_p');
            $table->integer('g_ansietas_0_14_l');
            $table->integer('g_ansietas_0_14_p');
            $table->integer('g_ansietas_15_59_l');
            $table->integer('g_ansietas_15_59_p');
            $table->integer('g_ansietas_60_l');
            $table->integer('g_ansietas_60_p');
            $table->integer('g_ansietas_depresi');
            $table->integer('g_ansietas_depresi_0_14_l');
            $table->integer('g_ansietas_depresi_0_14_p');
            $table->integer('g_ansietas_depresi_15_59_l');
            $table->integer('g_ansietas_depresi_15_59_p');
            $table->integer('g_ansietas_depresi_60_l');
            $table->integer('g_ansietas_depresi_60_p');
            $table->integer('g_depresi_0_14_l');
            $table->integer('g_depresi_0_14_p');
            $table->integer('g_depresi_15_59_l');
            $table->integer('g_depresi_15_59_p');
            $table->integer('g_depresi_60_l');
            $table->integer('g_depresi_60_p');
            $table->integer('g_penyalahgunaan_napza_0_14_l');
            $table->integer('g_penyalahgunaan_napza_0_14_p');
            $table->integer('g_penyalahgunaan_napza_15_59_l');
            $table->integer('g_penyalahgunaan_napza_15_59_p');
            $table->integer('g_penyalahgunaan_napza_60_l');
            $table->integer('g_penyalahgunaan_napza_60_p');
            $table->integer('g_anak_remaja_0_14_l');
            $table->integer('g_anak_remaja_0_14_p');
            $table->integer('g_anak_remaja_15_59_l');
            $table->integer('g_anak_remaja_15_59_p');
            $table->integer('g_anak_remaja_60_l');
            $table->integer('g_anak_remaja_60_p');
            $table->integer('g_psikotik_akut_0_14_l');
            $table->integer('g_psikotik_akut_0_14_p');
            $table->integer('g_psikotik_akut_15_59_l');
            $table->integer('g_psikotik_akut_15_59_p');
            $table->integer('g_psikotik_akut_60_l');
            $table->integer('g_psikotik_akut_60_p');
            $table->integer('skizofrenia_0_14_l');
            $table->integer('skizofrenia_0_14_p');
            $table->integer('skizofrenia_15_59_l');
            $table->integer('skizofrenia_15_59_p');
            $table->integer('skizofrenia_60_l');
            $table->integer('skizofrenia_60_p');
            $table->integer('g_somatoform_0_14_l');
            $table->integer('g_somatoform_0_14_p');
            $table->integer('g_somatoform_15_59_l');
            $table->integer('g_somatoform_15_59_p');
            $table->integer('g_somatoform_60_l');
            $table->integer('g_somatoform_60_p');
            $table->integer('insomnia_0_14_l');
            $table->integer('insomnia_0_14_p');
            $table->integer('insomnia_15_59_l');
            $table->integer('insomnia_15_59_p');
            $table->integer('insomnia_60_l');
            $table->integer('insomnia_60_p');
            $table->integer('percobaan_bunuh_diri_0_14_l');
            $table->integer('percobaan_bunuh_diri_0_14_p');
            $table->integer('percobaan_bunuh_diri_15_59_l');
            $table->integer('percobaan_bunuh_diri_15_59_p');
            $table->integer('percobaan_bunuh_diri_60_l');
            $table->integer('percobaan_bunuh_diri_60_p');
            $table->integer('redartasi_mental_0_14_l');
            $table->integer('redartasi_mental_0_14_p');
            $table->integer('redartasi_mental_15_59_l');
            $table->integer('redartasi_mental_15_59_p');
            $table->integer('redartasi_mental_60_l');
            $table->integer('redartasi_mental_60_p');
            $table->integer('g_kepribadian_perilaku_0_14_l');
            $table->integer('g_kepribadian_perilaku_0_14_p');
            $table->integer('g_kepribadian_perilaku_15_59_l');
            $table->integer('g_kepribadian_perilaku_15_59_p');
            $table->integer('g_kepribadian_perilaku_60_l');
            $table->integer('g_kepribadian_perilaku_60_p');
            $table->integer('jumlah_kasus');
            // $table->integer('g_neurotik');
            // $table->integer('g_jiwa_dan_perilaku_nifas');
            // $table->integer('gangguan_jiwa');
            // $table->integer('epilepsi');
            // $table->integer('kasus_bunuh_diri');
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
        Schema::dropIfExists('rekap_gangguan_jiwa');
    }
}
