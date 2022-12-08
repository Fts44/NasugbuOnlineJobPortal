<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;

class ApplicationController extends Controller
{
    public function index(){

        $ja = DB::table('job_application as ja')
            ->where('jp.jp_acc_id', session('user_id'))
            ->select('ja.*', 'jc.*', 'jp.jp_title', 'jp.jp_salary', 'a.*')
            ->leftjoin('job_post as jp', 'ja.jp_id', 'jp.jp_id')
            ->leftjoin('job_category as jc', 'jp.jp_category', 'jc.jc_id')
            ->leftjoin('accounts as a', 'ja.ja_applicant_id', 'a.acc_id')
            ->get();

        return view('Employer.Application')
            ->with([
                'ja' => $ja
            ]);

    }

    public function get_details($id){
        $jp = DB::table('job_application as ja')
            ->where('ja_id', $id)
            ->leftjoin('job_post as jp', 'ja.jp_id', 'jp.jp_id')
            ->leftjoin('job_category as jc', 'jp.jp_category', 'jc.jc_id')
            ->first();

        echo json_encode($jp);
    }

    public function respond(Request $request){
        $rules = [
            'status' => ['required'],
            'interview_date' => ['required_if:status,==,1'],
        ];

        $messages = [
            'interview_date.required_if' => 'The interview date is required'
        ];

        $validator = validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Error',
                'message' => 'Respond not saved',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            $ja = DB::table('job_application')
                ->where('ja_id', $request->ja_id)
                ->first();

            DB::table('job_application')
                ->where('ja_id', $request->ja_id)
                ->update([
                    'ja_status' => $request->status,
                    'ja_datetime' => ($request->status=='1') ? $request->interview_date : NULL,
                    'ja_result' => ($ja->ja_status=='1') ? $request->result : NULL
                ]);

            $response = [
                'title' => 'Success',
                'message' => 'Respond saved',
                'icon' => 'success',
                'status' => 200
            ];
        }

        return (object)$response;
    }
}
