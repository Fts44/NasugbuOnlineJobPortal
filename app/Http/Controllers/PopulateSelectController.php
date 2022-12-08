<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PopulateSelectController extends Controller
{
    public function get_province(){
        $province = DB::table('province')
            ->get();
        
        return $province;
    }

    public function get_municipality($prov_code){
        $municipality = DB::table('municipality')
            ->where('prov_code', $prov_code)
            ->get();

        return $municipality;
    }

    public function get_barangay($mun_code){
        $barangay = DB::table('barangay')
            ->where('mun_code', $mun_code)
            ->get();

        return $barangay;
    }
}
