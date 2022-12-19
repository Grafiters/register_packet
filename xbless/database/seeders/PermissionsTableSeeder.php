<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            //role
            ['nested' => '1', 'name' => 'Permission', 'slug' => 'permision.index'],
            ['nested' => '1.1', 'name' => 'Kabupaten', 'slug' => 'kabupaten.index'],
            ['nested' => '1.2', 'name' => 'Kecamatan', 'slug' => 'kecamatan.index'],
            ['nested' => '1.3', 'name' => 'Puskesmas', 'slug' => 'puskesmas.index'],

            //MASTER
            ['nested'=>'2', 'name'=>'Master', 'slug'=>'master.index'],

            //NEGARA
            ['nested'=>'2.1', 'name'=>'Provinsi', 'slug'=>'master.provinsi.index'],
            ['nested'=>'2.1.1', 'name'=>'Tambah Provinsi', 'slug'=>'master.provinsi.tambah'],
            ['nested'=>'2.1.2', 'name'=>'Ubah Provinsi', 'slug'=>'master.provinsi.ubah'],
            ['nested'=>'2.1.3', 'name'=>'Hapus Provinsi', 'slug'=>'master.provinsi.hapus'],

            //NEGARA
            ['nested'=>'2.2', 'name'=>'Kabupaten', 'slug'=>'master.kabupaten.index'],
            ['nested'=>'2.2.1', 'name'=>'Tambah Kabupaten', 'slug'=>'master.kabupaten.tambah'],
            ['nested'=>'2.2.2', 'name'=>'Ubah Kabupaten', 'slug'=>'master.kabupaten.ubah'],
            ['nested'=>'2.2.3', 'name'=>'Hapus Kabupaten', 'slug'=>'master.kabupaten.hapus'],

            //STAFF
            ['nested'=>'2.3', 'name'=>'Staff', 'slug'=>'staff.index'],
            ['nested'=>'2.3.1', 'name'=>'Tambah Staff', 'slug'=>'staff.tambah'],
            ['nested'=>'2.3.2', 'name'=>'Ubah Staff', 'slug'=>'staff.ubah'],
            ['nested'=>'2.3.3', 'name'=>'Detail Staff', 'slug'=>'staff.detail'],
            ['nested'=>'2.3.3', 'name'=>'Hapus Staff', 'slug'=>'staff.hapus'],
            

            //NEGARA
            ['nested'=>'2.4', 'name'=>'Kecamatan', 'slug'=>'master.kecamatan.index'],
            ['nested'=>'2.4.1', 'name'=>'Tambah Kecamatan', 'slug'=>'master.kecamatan.tambah'],
            ['nested'=>'2.4.2', 'name'=>'Ubah Kecamatan', 'slug'=>'master.kecamatan.ubah'],
            ['nested'=>'2.4.3', 'name'=>'Hapus Kecamatan', 'slug'=>'master.kecamatan.hapus'],

            //NEGARA
            ['nested'=>'2.5', 'name'=>'Puskesmas', 'slug'=>'master.puskesmas.index'],
            ['nested'=>'2.5.1', 'name'=>'Tambah Puskesmas', 'slug'=>'master.puskesmas.tambah'],
            ['nested'=>'2.5.2', 'name'=>'Ubah Puskesmas', 'slug'=>'master.puskesmas.ubah'],
            ['nested'=>'2.5.3', 'name'=>'Hapus Puskesmas', 'slug'=>'master.puskesmas.hapus'],

            // KASUS
            ['nested'=>'3', 'name'=>'Kasus', 'slug'=>'kasus.index'],

            // PTM
            ['nested'=>'3.1', 'name'=>'Kasus PTM', 'slug'=>'ptm.index'],
            ['nested'=>'3.1.1', 'name'=>'Tambah Kasus PTM', 'slug'=>'ptm.tambah'],
            ['nested'=>'3.1.2', 'name'=>'Ubah Kasus PTM', 'slug'=>'ptm.ubah'],
            ['nested'=>'3.1.3', 'name'=>'Hapus Kasus PTM', 'slug'=>'ptm.hapus'],

            // INDERA
            ['nested'=>'3.2', 'name'=>'Indera', 'slug'=>'indera.index'],
            ['nested'=>'3.2.1', 'name'=>'Indera', 'slug'=>'indera.simpan'],

            // JIWA
            ['nested'=>'3.3', 'name'=>'Kasus Jiwa', 'slug'=>'jiwa.index'],
            ['nested'=>'3.3.1', 'name'=>'Tambah Kasus Jiwa', 'slug'=>'jiwa.tambah'],
            ['nested'=>'3.3.2', 'name'=>'Ubah Kasus Jiwa', 'slug'=>'jiwa.ubah'],
            ['nested'=>'3.3.3', 'name'=>'Hapus Kasus Jiwa', 'slug'=>'jiwa.hapus'],

            // Napza
            ['nested'=>'3.4', 'name'=>'Kasus Napza', 'slug'=>'napza.index'],
            ['nested'=>'3.4.1', 'name'=>'Tambah Kasus Jiwa', 'slug'=>'napza.tambah'],
            ['nested'=>'3.4.2', 'name'=>'Ubah Kasus Jiwa', 'slug'=>'napza.ubah'],
            ['nested'=>'3.4.3', 'name'=>'Hapus Kasus Jiwa', 'slug'=>'napza.hapus'],

            // DETEKSI DINI
            ['nested'=>'4', 'name'=>'Deteksi Dini', 'slug'=>'index'],

            // KESWA
            ['nested'=>'4.1', 'name'=>'Keswa', 'slug'=>'keswa.index'],
            ['nested'=>'4.1.1', 'name'=>'Tambah Keswa', 'slug'=>'keswa.tambah'],
            ['nested'=>'4.1.2', 'name'=>'Ubah Keswa', 'slug'=>'keswa.ubah'],
            ['nested'=>'4.1.3', 'name'=>'Hapus Keswa', 'slug'=>'keswa.hapus'],

            // SDQ
            ['nested'=>'4.2', 'name'=>'SDQ', 'slug'=>'sdq.index'],
            ['nested'=>'4.2.1', 'name'=>'Tambah Data SDQ', 'slug'=>'sdq.tambah'],
            ['nested'=>'4.2.2', 'name'=>'Ubah Data SDQ', 'slug'=>'sdq.ubah'],
            ['nested'=>'4.2.3', 'name'=>'Hapus Data SDQ', 'slug'=>'sdq.hapus'],

            // ASSIST
            ['nested'=>'4.3', 'name'=>'Assist', 'slug'=>'dd_assist.index'],
            ['nested'=>'4.3.1', 'name'=>'Tambah Data Assist', 'slug'=>'dd_assist.tambah'],
            ['nested'=>'4.3.2', 'name'=>'Ubah Data Assist', 'slug'=>'dd_assist.ubah'],
            ['nested'=>'4.3.3', 'name'=>'Hapus Data Assist', 'slug'=>'dd_assist.hapus'],

            // PANDU
            ['nested'=>'4.4', 'name'=>'Pandu', 'slug'=>'dd_pandu.index'],
            ['nested'=>'4.4.1', 'name'=>'Tambah Data Pandu', 'slug'=>'dd_pandu.tambah'],
            ['nested'=>'4.4.2', 'name'=>'Ubah Data Pandu', 'slug'=>'dd_pandu.ubah'],
            ['nested'=>'4.4.3', 'name'=>'Hapus Data Pandu', 'slug'=>'dd_pandu.hapus'],

            // FORM D
            ['nested'=>'4.5', 'name'=>'Form D', 'slug'=>'form_d.index'],
            ['nested'=>'4.5.1', 'name'=>'Tambah Data Form D', 'slug'=>'form_d.tambah'],
            ['nested'=>'4.5.2', 'name'=>'Ubah Data Form D', 'slug'=>'form_d.ubah'],
            ['nested'=>'4.5.3', 'name'=>'Hapus Data Form D', 'slug'=>'form_d.hapus'],

            // FORM E
            ['nested'=>'4.6', 'name'=>'Form E', 'slug'=>'form_e.index'],
            ['nested'=>'4.6.1', 'name'=>'Tambah Data Form E', 'slug'=>'form_e.tambah'],
            ['nested'=>'4.6.2', 'name'=>'Ubah Data Form E', 'slug'=>'form_e.ubah'],
            ['nested'=>'4.6.3', 'name'=>'Hapus Data Form E', 'slug'=>'form_e.hapus'],

            // FORM F
            ['nested'=>'4.7', 'name'=>'Form F', 'slug'=>'form_f.index'],
            ['nested'=>'4.7.1', 'name'=>'Tambah Data Form F', 'slug'=>'form_f.tambah'],
            ['nested'=>'4.7.2', 'name'=>'Ubah Data Form F', 'slug'=>'form_f.ubah'],
            ['nested'=>'4.7.3', 'name'=>'Hapus Data Form F', 'slug'=>'form_f.hapus'],

            // FORM G
            ['nested'=>'4.8', 'name'=>'Form G', 'slug'=>'form_g.index'],

            // FORM H
            ['nested'=>'4.9', 'name'=>'Form H', 'slug'=>'form_h.index'],

            // FORM I
            ['nested'=>'4.a', 'name'=>'Form I', 'slug'=>'form_is.index'],

            // UBM
            ['nested'=>'4.b', 'name'=>'UBM', 'slug'=>'ubm.index'],
            ['nested'=>'4.b.1', 'name'=>'Tambah Data UBM', 'slug'=>'ubm.tambah'],
            ['nested'=>'4.b.2', 'name'=>'Ubah Data UBM', 'slug'=>'ubm.ubah'],
            ['nested'=>'4.b.3', 'name'=>'Hapus Data UBM', 'slug'=>'ubm.hapus'],

            // INDIKATOR
            ['nested'=>'5', 'name'=>'Indikator', 'slug'=>'indikator.index'],

            // SPM
            ['nested'=>'5.1', 'name'=>'Spm', 'slug'=>'spm.index'],
            ['nested'=>'5.1.1', 'name'=>'Tambah Data SPM', 'slug'=>'spm.tambah'],
            ['nested'=>'5.1.2', 'name'=>'Ubah Data SPM', 'slug'=>'spm.ubah'],
            ['nested'=>'5.1.3', 'name'=>'Hapus Data SPM', 'slug'=>'spm.hapus'],

            // RPJMD
            ['nested'=>'5.2', 'name'=>'RPJMD', 'slug'=>'rpjmd.index'],
            ['nested'=>'5.2.1', 'name'=>'Tambah Data RPJMD', 'slug'=>'rpjmd.tambah'],
            ['nested'=>'5.2.2', 'name'=>'Ubah Data RPJMD', 'slug'=>'rpjmd.ubah'],
            ['nested'=>'5.2.3', 'name'=>'Hapus Data RPJMD', 'slug'=>'rpjmd.hapus'],

            // PROGRAM
            ['nested'=>'5.3', 'name'=>'Program', 'slug'=>'program.index'],
            ['nested'=>'5.3.1', 'name'=>'Tambah Data Program', 'slug'=>'program.tambah'],
            ['nested'=>'5.3.2', 'name'=>'Ubah Data Program', 'slug'=>'program.ubah'],
            ['nested'=>'5.3.3', 'name'=>'Hapus Data Program', 'slug'=>'program.hapus'],
            
            // PROFIL
            ['nested'=>'6', 'name'=>'Profil', 'slug'=>'profil.index'],

            // Posbindu
            ['nested'=>'6.1', 'name'=>'Posbindu', 'slug'=>'profil.posbindu.index'],
            ['nested'=>'6.1.1', 'name'=>'Tambah Data Posbindu', 'slug'=>'profil.posbindu.tambah'],
            ['nested'=>'6.1.2', 'name'=>'Ubah Data Posbindu', 'slug'=>'profil.posbindu.ubah'],
            ['nested'=>'6.1.3', 'name'=>'Hapus Data Posbindu', 'slug'=>'profil.posbindu.hapus'],

            // Uspro
            ['nested'=>'6.2', 'name'=>'Uspro', 'slug'=>'profil.uspro.index'],
            ['nested'=>'6.2.1', 'name'=>'Tambah Data Uspro', 'slug'=>'profil.uspro.tambah'],
            ['nested'=>'6.2.2', 'name'=>'Ubah Data Uspro', 'slug'=>'profil.uspro.ubah'],
            ['nested'=>'6.2.3', 'name'=>'Hapus Data Uspro', 'slug'=>'profil.uspro.hapus'],

            // Hipertensi
            ['nested'=>'6.3', 'name'=>'Hipertensi', 'slug'=>'profil.hipertensi.index'],
            ['nested'=>'6.3.1', 'name'=>'Tambah Data Hipertensi', 'slug'=>'profil.hipertensi.tambah'],
            ['nested'=>'6.3.2', 'name'=>'Ubah Data Hipertensi', 'slug'=>'profil.hipertensi.ubah'],
            ['nested'=>'6.3.3', 'name'=>'Hapus Data Hipertensi', 'slug'=>'profil.hipertensi.hapus'],

            // DM
            ['nested'=>'6.4', 'name'=>'Data DM', 'slug'=>'profil.dm.index'],
            ['nested'=>'6.4.1', 'name'=>'Tambah Data DM', 'slug'=>'profil.dm.tambah'],
            ['nested'=>'6.4.2', 'name'=>'Ubah Data DM', 'slug'=>'profil.dm.ubah'],
            ['nested'=>'6.4.3', 'name'=>'Hapus Data DM', 'slug'=>'profil.dm.hapus'],

            // iva
            ['nested'=>'6.5', 'name'=>'IVA', 'slug'=>'profil.iva.index'],
            ['nested'=>'6.5.1', 'name'=>'Tambah Data IVA', 'slug'=>'profil.iva.tambah'],
            ['nested'=>'6.5.2', 'name'=>'Ubah Data IVA', 'slug'=>'profil.iva.ubah'],
            ['nested'=>'6.5.3', 'name'=>'Hapus Data IVA', 'slug'=>'profil.iva.hapus'],

            // ODGJ
            ['nested'=>'6.6', 'name'=>'ODGJ', 'slug'=>'profil.odgj.index'],
            ['nested'=>'6.6.1', 'name'=>'Tambah Data ODGJ', 'slug'=>'profil.odgj.tambah'],
            ['nested'=>'6.6.2', 'name'=>'Ubah Data ODGJ', 'slug'=>'profil.odgj.ubah'],
            ['nested'=>'6.6.3', 'name'=>'Hapus Data ODGJ', 'slug'=>'profil.odgj.hapus'],

            // PTM KESWA
            ['nested'=>'6.7', 'name'=>'PTM KESWA', 'slug'=>'profil.ptm_keswa.index'],
            ['nested'=>'6.7.1', 'name'=>'Tambah PTM KESWA', 'slug'=>'profil.ptm_keswa.tambah'],
            ['nested'=>'6.7.2', 'name'=>'Ubah PTM KESWA', 'slug'=>'profil.ptm_keswa.ubah'],
            ['nested'=>'6.7.3', 'name'=>'Hapus PTM KESWA', 'slug'=>'profil.ptm_keswa.hapus'],

            // SDM
            ['nested'=>'6.8', 'name'=>'SDM', 'slug'=>'profil.sdm.index'],
            ['nested'=>'6.8.1', 'name'=>'Tambah Data SDM', 'slug'=>'profil.sdm.tambah'],
            ['nested'=>'6.8.2', 'name'=>'Ubah Data SDM', 'slug'=>'profil.sdm.ubah'],
            ['nested'=>'6.8.3', 'name'=>'Hapus Data SDM', 'slug'=>'profil.sdm.hapus'],

            // Data Ipwl
            ['nested'=>'6.9', 'name'=>'Data Ipwl', 'slug'=>'profil.ipwl.index'],
            ['nested'=>'6.9.1', 'name'=>'Tambah Data Ipwl', 'slug'=>'profil.ipwl.tambah'],
            ['nested'=>'6.9.2', 'name'=>'Ubah Data Ipwl', 'slug'=>'profil.ipwl.ubah'],
            ['nested'=>'6.9.3', 'name'=>'Hapus Data Ipwl', 'slug'=>'profil.ipwl.hapus'],

            // DEMOGRAFI
            ['nested'=>'6.a', 'name'=>'Demografi', 'slug'=>'profil.demografi.index'],
            ['nested'=>'6.a.1', 'name'=>'Tambah Data Demografi', 'slug'=>'profil.demografi.tambah'],
            ['nested'=>'6.a.2', 'name'=>'Ubah Data Demografi', 'slug'=>'profil.demografi.ubah'],
            ['nested'=>'6.a.3', 'name'=>'Hapus Data Demografi', 'slug'=>'profil.demografi.hapus'],

            // REGULASI
            ['nested'=>'7', 'name'=>'Regulasi', 'slug'=>'regulasi.index'],

            // Posbindu
            ['nested'=>'7.1', 'name'=>'Posbindu', 'slug'=>'regulasi.index'],
            ['nested'=>'7.2', 'name'=>'Tambah Data Posbindu', 'slug'=>'regulasi.tambah'],
            ['nested'=>'7.3', 'name'=>'Ubah Data Posbindu', 'slug'=>'regulasi.ubah'],
            ['nested'=>'7.4', 'name'=>'Hapus Data Posbindu', 'slug'=>'regulasi.hapus'],

            // ANALISA
            ['nested'=>'8', 'name'=>'Analisa', 'slug'=>'analisa.index'],

            // grafik ptm
            ['nested'=>'8.1', 'name'=>'Grafik PTM', 'slug'=>'analisa_kasus_ptm.index'],

            // grafik gangguan
            ['nested'=>'8.2', 'name'=>'Grafik Gangguan', 'slug'=>'gangguan.index'],

            // grafik pandu
            ['nested'=>'8.3', 'name'=>'Grafik Analisa Pandu', 'slug'=>'analisa_kasus_pandu.index'],

            // grafik puskesmas posbindu
            ['nested'=>'8.4', 'name'=>'Grafik Puskesmas Posbindu', 'slug'=>'pusk_posbindu.index'],

            // grafik desa posbindu
            ['nested'=>'8.5', 'name'=>'Grafik Desa Posbindu', 'slug'=>'desa_posbindu.index'],

            // grafik faktor resiko
            ['nested'=>'8.6', 'name'=>'Grafik Faktor Resiko', 'slug'=>'faktor_resiko.index'],

            // grafik pemeriksaan
            ['nested'=>'8.7', 'name'=>'Grafik Pemeriksaan', 'slug'=>'pemeriksanaan_dd.index'],

            // grafik puskesmas iva sadanis
            ['nested'=>'8.8', 'name'=>'Grafik Puskesmas Iva Sadanis', 'slug'=>'pusk_ivasadanis.index'],

            // grafik temuan tindakan iva krio
            ['nested'=>'8.9', 'name'=>'Grafik Temuan Tindakan IVA & KRIO', 'slug'=>'temuan_tindakan_iva_krio.index'],

            // grafik temuan sadanis
            ['nested'=>'8.10', 'name'=>'Grafik Temuan Sadanis', 'slug'=>'temuansadanis.index'],

            // grafik temuan iva
            ['nested'=>'8.11', 'name'=>'Grafik Temuan IVA', 'slug'=>'temuaniva.index'],

            // grafik layanan ubm
            ['nested'=>'8.12', 'name'=>'Grafik Layanan UBM', 'slug'=>'layubm.index'],

            // grafik assist
            ['nested'=>'8.13', 'name'=>'Grafik Assist', 'slug'=>'assist.index'],

            // USER GUIDE
            ['nested'=>'9', 'name'=>'User Guide', 'slug'=>'user_guide.index'],

            // user_guide
            ['nested'=>'9.1', 'name'=>'Manual Book', 'slug'=>'m_book.index'],
            ['nested'=>'9.1.1', 'name'=>'Tambah Data Manual Book', 'slug'=>'m_book.tambah'],
            ['nested'=>'9.1.2', 'name'=>'Ubah Data Manual Book', 'slug'=>'m_book.ubah'],
            ['nested'=>'9.1.3', 'name'=>'Hapus Data Manual Book', 'slug'=>'m_book.hapus'],

            // Note
            ['nested'=>'9.2', 'name'=>'NOTE', 'slug'=>'notes.index'],
            ['nested'=>'9.2.1', 'name'=>'Tambah Data NOTE', 'slug'=>'notes.tambah'],
            ['nested'=>'9.2.2', 'name'=>'Ubah Data NOTE', 'slug'=>'notes.ubah'],
            ['nested'=>'9.2.3', 'name'=>'Hapus Data NOTE', 'slug'=>'notes.hapus'],
            
            // MANAJEMEN
            ['nested'=>'f', 'name'=>'Keamanan', 'slug'=>'security.index'],
            ['nested'=>'f.1', 'name'=>'Modul', 'slug'=>'permission.index'],
            ['nested'=>'f.1.1', 'name'=>'Tambah Modul', 'slug'=>'permission.tambah'],
            ['nested'=>'f.1.2', 'name'=>'Ubah Modul', 'slug'=>'permission.ubah'],
            
            ['nested'=>'f.2', 'name'=>'Akses', 'slug'=>'role.index'],
            ['nested'=>'f.2.1', 'name'=>'Tambah Akses', 'slug'=>'role.tambah'],
            ['nested'=>'f.2.2', 'name'=>'Ubah Akses', 'slug'=>'role.ubah'],
            ['nested'=>'f.2.3', 'name'=>'Daftar User Akses', 'slug'=>'role.user'],
            ['nested'=>'f.2.4', 'name'=>'Hapus Akses', 'slug'=>'role.hapus'],

        ]);
    }
}