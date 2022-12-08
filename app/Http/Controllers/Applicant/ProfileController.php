<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PopulateSelectController as PSC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Storage;

class ProfileController extends Controller
{
    public function get_user_details(){
        $acc = DB::table('accounts as a')
            ->select(
                'a.*', 
                'aa.add_prov as ep','aa.add_mun as em','aa.add_brgy as eb',
            )
            ->where('acc_email', Session('user_email'))
            ->leftjoin('address as aa', 'a.acc_add_id', 'aa.add_id')
            ->first();
        return $acc;
    }

    public function index(){
        
        $acc = $this->get_user_details();

        $PSC = new PSC;
        $province = $PSC->get_province();
        $municipality = $PSC->get_municipality('0410');
        $barangay = $PSC->get_barangay('041019');

        return view('Applicant.Profile', compact(
            'acc',
            'province', 'municipality', 'barangay'
        ));
    }

    public function update(Request $request){
        $rules = [
            'applicant_profile_picture' => ['required_without:applicant_profile_picture_prev'],
            'applicant_firstname' => ['required'],
            'applicant_middlename' => ['required'],
            'applicant_lastname' => ['required'],
            'applicant_email' => ['required'],
            'applicant_phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:11', 'unique:accounts,acc_phone,'.Session('user_email').',acc_email'],
            'applicant_birthdate' => ['required'],
            'applicant_sex' => ['required'],
            'applicant_province' => ['required'],
            'applicant_municipality' => ['required'],
            'applicant_barangay' => ['required']
        ];

        $messages = [
            'applicant_profile_picture.required_without' => 'The business logo field is required.'
        ];
        $validator = validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Error',
                'message' => 'Invalid Inputs',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            try{   
                $acc = $this->get_user_details();

                // get previouse picture 
                $app = $acc->acc_biz_logo;

                // profile picture
                if($request->applicant_profile_picture){
                    $path = '/public/profile_picture/';
                    $file = $request->file('applicant_profile_picture');
                    $app = $acc->acc_id.'_'.time().'.'.$file->extension();
                    $upload = $file->storeAs($path, $app);
                    $request->session()->put('user_pic', $app);
                    if($acc->acc_biz_logo){
                        Storage::delete($path.$acc->acc_biz_logo); 
                    }
                }

                if($acc->acc_add_id){
                    DB::table('address')
                        ->where('add_id', $acc->acc_add_id)
                        ->update([
                            'add_prov' => $request->applicant_province,
                            'add_mun' => $request->applicant_municipality,
                            'add_brgy' => $request->applicant_barangay
                        ]);
                }
                else{
                    $acc->acc_add_id = DB::table('address')
                        ->insertGetId([
                            'add_prov' => $request->applicant_province,
                            'add_mun' => $request->applicant_municipality,
                            'add_brgy' => $request->applicant_barangay
                        ]);
                }

                DB::table('accounts')
                    ->where('acc_email', Session('user_email'))
                    ->update([
                        'acc_firstname' => $request->applicant_firstname,
                        'acc_middlename' => $request->applicant_middlename,
                        'acc_lastname' => $request->applicant_lastname,
                        'acc_suffixname' => $request->applicant_suffixname,
                        'acc_phone' => $request->applicant_phone,
                        'acc_birthdate' => $request->applicant_birthdate,
                        'acc_sex' => $request->applicant_sex,
                        'acc_add_id' => $acc->acc_add_id,
                        'acc_biz_logo' => $app
                    ]);
                $response = [
                    'title' => 'Success',
                    'message' => 'Profile updated!',
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
