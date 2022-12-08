<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function index(){
        $app = DB::table('accounts')
            ->where('acc_classification', 'applicant')
            ->get()
            ->count();


        $emp = DB::table('accounts')
            ->where('acc_classification', 'employer')
            ->get()
            ->count();

        $jp = DB::table('job_post')
            ->get()
            ->count();

        $ja = DB::table('job_application')
            ->get()
            ->count();

        $jpc = DB::table('job_post as jp')
            ->selectRaw('jc.jc_category, count(*) as total')
            ->leftjoin('job_category as jc', 'jp.jp_category', 'jc.jc_id')
            ->groupBy('jc.jc_id')
            ->orderBy('total','DESC')
            ->take(5)
            ->get();
        
        $va = DB::table('premium_application')
            ->where('pa_validity', '>=', date('Y-m-d'))
            ->get()
            ->count();

        // echo $va;
        // echo json_encode($jpc);
        // echo $va;
        return view('Admin.Dashboard', compact(
            'app', 'emp',
            'jp', 'ja', 'jpc', 'va'
        ));
    }
}
