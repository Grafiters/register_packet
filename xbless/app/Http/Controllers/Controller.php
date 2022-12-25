<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Routing\Controller as BaseController;

use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function safe_encode($string) {
        $data = str_replace(array('/'),array('_'),$string);
        return $data;
    }

    function safe_decode($string,$mode=null) {
        $data = str_replace(array('_'),array('/'),$string);
        return $data;
    }

    function cekExist($table,$column,$var,$id){
        $cek = DB::table($table)->where('id','!=',$id)->where($column,'=',$var)->first();
        return (!empty($cek) ? false : true);
    }

    function duplicateEntry($content){
        return response()->json([
            'code'      => 400,
            'message'   => $content.' sudah terdaftar dalam sistem'
        ]);
    }

    function successSubmit($action, $data){
        return response()->json([
            'code'      => 201,
            'message'   => 'Success '.$action.' Data',
            'data'      => $data
        ]);
    }

    function failSubmit($message){
        return response()->json([
            'code'      => 400,
            'message'   => $message
        ]);
    }

    function nodata($data){
        return response()->json([
            'code'      => 400,
            'message'   => $data
        ]);
    }
}
