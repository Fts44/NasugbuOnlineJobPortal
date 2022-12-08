<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;

class PrintController extends Controller
{
    public function print_interview($id){
        $d = DB::table('job_application as ja')
            ->select('ja.*', 'jp.jp_title', 
                'ae.acc_biz_logo as biz_logo', 'ae.acc_biz_name as biz_name', 'ae.acc_biz_phone as biz_phone', 'ae.acc_biz_tel as biz_tel',
                'pb.prov_name as biz_prov', 'mb.mun_name as biz_mun', 'bb.brgy_name as biz_brgy', 'ab.add_landmark as biz_landmark',
                'ae.acc_firstname as ae_firstname', 'ae.acc_middlename as ae_middlename', 'ae.acc_lastname as ae_lastname', 'ae.acc_sex as ae_sex',
                'aa.acc_firstname as aa_firstname', 'aa.acc_middlename as aa_middlename', 'aa.acc_lastname as aa_lastname', 'aa.acc_sex as aa_sex',
            )
            ->where('ja.ja_id', $id)
            ->leftjoin('job_post as jp', 'ja.jp_id', 'jp.jp_id')
            ->leftjoin('job_category as jc', 'jp.jp_category', 'jc.jc_id')
            ->leftjoin('accounts as ae', 'jp.jp_acc_id', 'ae.acc_id')
            ->leftjoin('address as ab', 'ae.acc_biz_add_id', 'ab.add_id')

            ->leftjoin('province as pb', 'ab.add_prov', 'pb.prov_code')
            ->leftjoin('municipality as mb', 'ab.add_mun', 'mb.mun_code')
            ->leftjoin('barangay as bb', 'ab.add_brgy', 'bb.brgy_code')

            ->leftjoin('accounts as aa', 'ja.ja_applicant_id', 'aa.acc_id')
        ->first();

        $filename = 'Interview_Details';
        // echo json_encode($d);
        $pdf = PDF::loadView('Reports.Forms.Interview', compact('d', 'filename'));
        $pdf->setPaper('letter', 'portrait');
        
        return $pdf->stream($filename);
    }

    public function print_result($id){
        $d = DB::table('job_application as ja')
            ->select('ja.*', 'jp.jp_title', 
                'ae.acc_biz_logo as biz_logo', 'ae.acc_biz_name as biz_name', 'ae.acc_biz_phone as biz_phone', 'ae.acc_biz_tel as biz_tel',
                'pb.prov_name as biz_prov', 'mb.mun_name as biz_mun', 'bb.brgy_name as biz_brgy', 'ab.add_landmark as biz_landmark',
                'ae.acc_firstname as ae_firstname', 'ae.acc_middlename as ae_middlename', 'ae.acc_lastname as ae_lastname', 'ae.acc_sex as ae_sex',
                'aa.acc_firstname as aa_firstname', 'aa.acc_middlename as aa_middlename', 'aa.acc_lastname as aa_lastname', 'aa.acc_sex as aa_sex',
            )
            ->where('ja.ja_id', $id)
            ->leftjoin('job_post as jp', 'ja.jp_id', 'jp.jp_id')
            ->leftjoin('job_category as jc', 'jp.jp_category', 'jc.jc_id')
            ->leftjoin('accounts as ae', 'jp.jp_acc_id', 'ae.acc_id')
            ->leftjoin('address as ab', 'ae.acc_biz_add_id', 'ab.add_id')

            ->leftjoin('province as pb', 'ab.add_prov', 'pb.prov_code')
            ->leftjoin('municipality as mb', 'ab.add_mun', 'mb.mun_code')
            ->leftjoin('barangay as bb', 'ab.add_brgy', 'bb.brgy_code')

            ->leftjoin('accounts as aa', 'ja.ja_applicant_id', 'aa.acc_id')
        ->first();

        $filename = 'Interview_Details';
        // echo json_encode($d);
        $pdf = PDF::loadView('Reports.Forms.Result', compact('d', 'filename'));
        $pdf->setPaper('letter', 'portrait');
        
        return $pdf->stream($filename);
    } 
}
