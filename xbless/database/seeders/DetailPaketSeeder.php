<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class DetailPaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 3; $i++) { 
            for ($j=3; $j <= 4 ; $j++) { 
                DB::table('detail_pakets')->insert([
                    "code"  => strtoupper(Str::random(8)),
                    "paket_id"  => $j,
                    "speed_id"  => 2,
                    "price"     => $i."00000",
                    "description"=> "<ul><li>speed up to 40 Mbps</li><li>disney land video<br></li></ul>"
                ]);
    
                DB::table('detail_pakets')->insert([
                    "code"  => strtoupper(Str::random(8)),
                    "paket_id"  => $j,
                    "speed_id"  => 5,
                    "price"     => $i."00000",
                    "description"=> "<ul><li>speed up to 50 Mbps</li><li>disney land video<br></li></ul>"
                ]);
            }
        } 
    }
}