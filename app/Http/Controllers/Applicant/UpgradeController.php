<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Storage;

class UpgradeController extends Controller
{
    public function index(){
        $application = DB::table('premium_application')
            ->where('acc_id', Session('user_id'))
            ->orderBy('pa_date', 'desc')
            ->get();
            
        $latest_pa = DB::table('premium_application')
            ->where('acc_id', Session('user_id'))
            ->orderBy('pa_date', 'desc')
            ->first();
        // echo json_encode($application);
        return view('Applicant.Upgrade', compact(
            'application', 'latest_pa'
        ));
    }

    public function send(Request $request){
        $rules = [
            'business_permit' => ['required']
        ];

        $messages = [
            'business_permit.required' => 'The barangay residency field is required.'
        ];
        $validator = validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Error',
                'message' => 'Application not submitted',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            try{
                if($request->business_permit){
                    $path = '/public/requirements/';
                    $file = $request->file('business_permit');
                    $business_permit = Session('user_id').'_'.time().'.'.$file->extension();
                    $upload = $file->storeAs($path, $business_permit);
                }

                DB::table('premium_application')->insert([
                    'pa_file' => $business_permit,
                    'acc_id' => Session('user_id')
                ]);

                $response = [
                    'title' => 'Success',
                    'message' => 'Business permit submitted.',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){

            }
        }
        return (object)$response;
    }
}
