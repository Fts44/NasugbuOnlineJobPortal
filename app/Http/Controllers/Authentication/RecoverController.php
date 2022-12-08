<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OTPController;
use App\Rules\PasswordRule as PasswordRule;

use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;

class RecoverController extends Controller
{
    public function index(){
        return view('authentication.recover');
    }

    public function recover(Request $request){

        $rules = [
            'email' => ['required', 'email', 'exists:accounts,acc_email'],
            'pass' => ['required', 'max:20', new PasswordRule],
            'cpass' => ['required','same:pass'],
            'otp' => ['required', 'numeric']
        ];

        $messages = [
            'cpass.required' => 'The confirm password field is required.',
            'cpass.same' => 'The confirm password does not match..',
            'pass.required' => 'The confirm password field is required.',
            'pass.max' => 'The password must not be greater than 20 characters.',
            'email.exists' => 'The email is not registered.'
        ];

        $validator = Validator::make( $request->all(), $rules, $messages);
    
        $verify_otp_request = new Request([
            'email' => $request->email,
            'otp' => $request->otp,
        ]);

        $OTPController = new OTPController;
        $OtpStatus = $OTPController->verify_otp($verify_otp_request);
        
        if(!$OtpStatus){
            $validator->errors()->add('otp', 'The otp is invalid.');
            throw new ValidationException($validator);
        }

        if($validator->fails()){
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->all());
        }
        else{

            DB::table('accounts')
                ->where('acc_email', $request->email)
                ->update([
                    'acc_password' => Hash::make($request->pass),
                    'acc_login_attempts' => '3',
                    'acc_login_attempts_date' => null,
                    'acc_blocked_status' => '0'
                ]);

            Session::flush();
            $response = [
                'title' => 'Success!',
                'message' => 'Account recovered.',
                'icon' => 'success',
                'status' => 200
            ];
            $response = json_encode($response, true);
            return redirect()->back()->with('status',$response);
           
        }
    }
}
