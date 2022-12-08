<?php

namespace App\Http\Controllers\Admin\Upgrade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;

class RequestController extends Controller
{
    public function index(){
        $request = DB::table('premium_application as pa')
            ->where('pa_status', 0)
            ->leftjoin('accounts as a', 'pa.acc_id', 'a.acc_id')
        ->get();

        return view('Admin.Upgrade.Request')
            ->with([
                'request' => $request
            ]);
    }

    public function respond(Request $request, $id){
        $rules = [
            'respond' => ['required'],
            'validity_date' => ['nullable', 'date', 'required_if:respond,==,1']
        ];

        $messages = [
            'validity_date.required_if' => 'The validity date is required.'
        ];

        $validator = validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
           
            $response = [
                'title' => 'Failed!',
                'message' => 'Missing inputs.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            DB::table('premium_application')->where('pa_id', $id)->update([
                'pa_validity' => $request->validity_date,
                'pa_status' => $request->respond
            ]);

            $response = [
                'title' => 'Success!',
                'message' => 'The request updated.',
                'icon' => 'success',
                'status' => 200
            ];
        }
        return (object)$response;
    }
}
