<?php

use App\Models\Puskesmas;

function explode_kab($kab){
    $explode = explode(' ', $kab);
    if($explode[0] != 'KOTA'){
        $kab_name = ucwords(strtolower($explode[1]));
    }else{
        $kab_name = ucwords(strtolower($kab));
    }
    return $kab_name;
}
function puskesmas_id($kab){
    $data = Puskesmas::where('kabupaten', explode_kab($kab))->pluck('id');
    return $data;
}
function puskesmas_wherein($kab){
    // return $kab;
    $data = Puskesmas::whereIn('kabupaten', $kab)->pluck('id');
    return $data;

}
?>
