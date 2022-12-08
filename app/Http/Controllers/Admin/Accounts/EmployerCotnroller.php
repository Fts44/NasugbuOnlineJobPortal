<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\PopulateSelectController as PSC;
use DB;

class EmployerCotnroller extends Controller
{
    public function get_user_details($id){
        $acc = DB::table('accounts as a')
            ->select(
                'a.*', 
                'aa.add_prov as ep','aa.add_mun as em','aa.add_brgy as eb',
                'ba.add_prov as ap','ba.add_mun as am','ba.add_brgy as ab','ba.add_landmark as al',
            )
            ->where('acc_id', $id)
            ->leftjoin('address as aa', 'a.acc_add_id', 'aa.add_id')
            ->leftjoin('address as ba', 'a.acc_biz_add_id', 'ba.add_id')
            ->first();
        return $acc;
    }

    public function index(){
        $emp = DB::select("SELECT a.*, 
            IFNULL((   SELECT pa.pa_status 
                FROM `premium_application` as pa 
                WHERE pa.acc_id=a.acc_id 
             	AND pa.pa_date >= DATE(NOW())
                ORDER BY pa_date 
                DESC LIMIT 1
            ), 0) AS 'status',
            ep.prov_name AS ep,
            em.mun_name AS em,
            eb.brgy_name AS eb
            FROM `accounts` AS a 
            LEFT JOIN `address` AS ea
            ON a.acc_add_id=ea.add_id 
            LEFT JOIN `province` AS ep 
            ON ep.prov_code=ea.add_prov 
            LEFT JOIN `municipality`AS em 
            ON em.mun_code=ea.add_mun 
            LEFT JOIN `barangay` AS eb 
            ON eb.brgy_code=ea.add_brgy 
            WHERE a.acc_classification='employer' 
        ");
        // echo json_encode($emp);
        return view("Admin.Accounts.Employer", compact(
            'emp'
        ));
    }

    public function employer($id){
        $acc = $this->get_user_details($id);

        $PSC = new PSC;
        $province = $PSC->get_province();
        $municipality = $PSC->get_municipality('0410');
        $barangay = $PSC->get_barangay('041019');
        $emun = $PSC->get_municipality($acc->ep);
        $ebrgy = $PSC->get_barangay($acc->em);

        return view('Admin.Accounts.ViewEmployer',compact(
            'acc',
            'province', 'municipality', 'barangay',
            'emun', 'ebrgy'
        ));
    }
}
