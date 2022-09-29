<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;
use Session;

class LoginController extends Controller
{
    public function index(){
        return view('authentication.login');
    }

    public function login(Request $request){
        $rules = [
            'email' => ['required', 'email', 'exists:accounts,acc_email'],
            'pass' => 'required',
        ];

        $messages = [
            'email.exists' => 'The email is not registered.',
            'pass.required' => 'The password field is required.'
        ];

        $validator = Validator::make( $request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            $user = DB::table('accounts')
                ->where('acc_email',$request->email)
                ->first();

            if($user){
                if(Hash::check($request->pass, $user->acc_password)){
                    $request->session()->put('user_email', $user->acc_email);
                    $request->session()->put('user_type', $user->acc_classification);
                    $response = [
                        'status' => 200,
                    ];

                    if($user->acc_classification == 'employer'){
                        $response['redirect_to'] = route('ProfileEmployerView');
                    }
                    else{
                        $response['redirect_to'] = "route('ProfileEmployerView')";
                    }
                }
                else{        
                    $response = [
                        'status' => 400,
                        'errors' => ['pass' => 'Incorrect password!']
                    ];
                }
            }
            else{
                $response = [
                    'status' => 400,
                    'errors' => ['email' => 'The email is not registered.']
                ];
            }
        }
        echo json_encode($response);
    }

    public function logout(){
        Session::flush();
        return redirect('/');
    }
}
