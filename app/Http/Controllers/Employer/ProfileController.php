<?php

namespace App\Http\Controllers\Employer;

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
                'ba.add_prov as ap','ba.add_mun as am','ba.add_brgy as ab','ba.add_landmark as al',
            )
            ->where('acc_email', Session('user_email'))
            ->leftjoin('address as aa', 'a.acc_add_id', 'aa.add_id')
            ->leftjoin('address as ba', 'a.acc_biz_add_id', 'ba.add_id')
            ->first();
        return $acc;
    }
    public function index(){
        
        $acc = $this->get_user_details();

        $PSC = new PSC;
        $province = $PSC->get_province();
        $municipality = $PSC->get_municipality('0410');
        $barangay = $PSC->get_barangay('041019');
        $emun = $PSC->get_municipality($acc->ep);
        $ebrgy = $PSC->get_barangay($acc->em);

        return view('Employer.Profile', compact(
            'acc',
            'province', 'municipality', 'barangay',
            'emun', 'ebrgy'
        ));
    }

    public function update(Request $request){

        $rules = [
            'business_logo' => ['required_without:bussiness_logo_prev'],
            'business_name' => ['required'],
            'business_province' => ['required'],
            'business_municipality' => ['required'],
            'business_barangay' => ['required'],
            'business_landmark' => ['required'],
            'business_tel' => ['nullable'],
            'business_phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:11', 'unique:accounts,acc_biz_phone,'.Session('user_email').',acc_email'],
            'employer_firstname' => ['required'],
            'employer_middlename' => ['required'],
            'employer_lastname' => ['required'],
            'employer_email' => ['required'],
            'employer_phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:11', 'unique:accounts,acc_phone,'.Session('user_email').',acc_email'],
            'employer_birthdate' => ['required'],
            'employer_sex' => ['required'],
            'employer_province' => ['required'],
            'employer_municipality' => ['required'],
            'employer_barangay' => ['required']
        ];

        $messages = [
            'business_logo.required_without' => 'The business logo field is required.'
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
                $business_logo = $acc->acc_biz_logo;

                // profile picture
                if($request->business_logo){
                    $path = '/public/profile_picture/';
                    $file = $request->file('business_logo');
                    $business_logo = $acc->acc_id.'_'.time().'.'.$file->extension();
                    $upload = $file->storeAs($path, $business_logo);
                    $request->session()->put('user_pic', $business_logo);
                    if($acc->acc_biz_logo){
                        Storage::delete($path.$acc->acc_biz_logo); 
                    }
                }

                if($acc->acc_add_id){
                    DB::table('address')
                        ->where('add_id', $acc->acc_add_id)
                        ->update([
                            'add_prov' => $request->employer_province,
                            'add_mun' => $request->employer_municipality,
                            'add_brgy' => $request->employer_barangay
                        ]);
                }
                else{
                    $acc->acc_add_id = DB::table('address')
                        ->insertGetId([
                            'add_prov' => $request->employer_province,
                            'add_mun' => $request->employer_municipality,
                            'add_brgy' => $request->employer_barangay
                        ]);
                }

                if($acc->acc_biz_add_id){
                    DB::table('address')
                        ->where('add_id', $acc->acc_biz_add_id)
                        ->update([
                            'add_prov' => $request->business_province,
                            'add_mun' => $request->business_municipality,
                            'add_brgy' => $request->business_barangay,
                            'add_landmark' => $request->business_landmark
                        ]);
                }
                else{
                    $acc->acc_biz_add_id = DB::table('address')
                        ->insertGetId([
                            'add_prov' => $request->business_province,
                            'add_mun' => $request->business_municipality,
                            'add_brgy' => $request->business_barangay,
                            'add_landmark' => $request->business_landmark
                        ]);
                }

                DB::table('accounts')
                    ->where('acc_email', Session('user_email'))
                    ->update([
                        'acc_firstname' => $request->employer_firstname,
                        'acc_middlename' => $request->employer_middlename,
                        'acc_lastname' => $request->employer_lastname,
                        'acc_suffixname' => $request->employer_suffixname,
                        'acc_phone' => $request->employer_phone,
                        'acc_birthdate' => $request->employer_birthdate,
                        'acc_sex' => $request->employer_sex,
                        'acc_add_id' => $acc->acc_add_id,
                        'acc_biz_name' => $request->business_name,
                        'acc_biz_logo' => $business_logo,
                        'acc_biz_phone' => $request->business_phone,
                        'acc_biz_tel' => $request->business_tel,
                        'acc_biz_add_id' => $acc->acc_biz_add_id,
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
