<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ApplicationController extends Controller
{
    public function index(){
        $ja = DB::table('job_application as ja')
            ->where('ja.ja_applicant_id', session('user_id'))
            ->select('ja.*', 'jc.*', 'jp.jp_title', 'jp.jp_salary')
            ->leftjoin('job_post as jp', 'ja.jp_id', 'jp.jp_id')
            ->leftjoin('job_category as jc', 'jp.jp_category', 'jc.jc_id')
            ->get();

        return view('Applicant.Application')
            ->with([
                'ja' => $ja
            ]);
    }

    public function cancel($id){
        $ja = DB::table('job_application')->where('ja_id', $id)->first();
  
    }
}
