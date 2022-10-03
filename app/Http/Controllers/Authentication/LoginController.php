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

            // check if user email is registered
            if($user->acc_blocked_status == '0'){

                // check if user password matched
                if(Hash::check($request->pass, $user->acc_password)){
                    
                    // reset acc login attempts
                    DB::table('accounts')->where('acc_email', $request->email)
                        ->update([
                            'acc_login_attempts' => '3'
                        ]);

                    // session the credentials
                    $request->session()->put('user_email', $user->acc_email);
                    $request->session()->put('user_password', $user->acc_password);
                    $request->session()->put('user_type', $user->acc_classification);

                    $response = [
                        'status' => 200,
                    ];

                    // redirect to designated page per user type
                    if($user->acc_classification == 'employer'){
                        $response['redirect_to'] = route('ProfileEmployerView');
                    }
                    elseif($user->acc_classification == 'admin'){
                        $response['redirect_to'] = route('ProfileAdminAccounts');
                    }
                    else{
                        $response['redirect_to'] = "route('ProfileEmployerView')";
                    }

                }
                else{  
                    
                    if($user->acc_login_attempts_date == date("Y-m-d")){

                        $login_attempts_left = $user->acc_login_attempts;
                        $login_attempts_left--;

                        if($login_attempts_left <= 0 ){
                            DB::table('accounts')->where('acc_email', $request->email)
                                ->update([
                                    'acc_blocked_status' => 1,
                                    'acc_login_attempts' => 0
                                ]);
                        }
                        else{
                            DB::table('accounts')->where('acc_email', $request->email)
                                ->update([
                                    'acc_login_attempts' => $login_attempts_left
                                ]);
                        }

                    }
                    else{
                        $login_attempts_left = 2;

                        DB::table('accounts')->where('acc_email', $request->email)
                            ->update([
                                'acc_login_attempts_date' => date("Y-m-d"),
                                'acc_login_attempts' => 2
                            ]);
                    }

                    if($login_attempts_left == 0){
                        $response = [
                            'title' => 'Account is Blocked!',
                            'message' => 'Your account is temporarily blocked due to 3 failed login attempts. Recover it <a href="'.route('RecoverView').'">here.</a>',
                            'icon' => 'warning'
                        ];
                    }
                    else{
                        $response = [
                            'title' => 'Incorrect Password!',
                            'message' => 'Login attempts left: '.$login_attempts_left.'/3',
                            'icon' => 'warning'
                        ];
                    }

                    $response = [
                        'status' => 400,
                        'errors' => ['pass' => 'Incorrect password!'],
                        'response' => $response
                    ];
                }
            }
            else{
                $response = [
                    'status' => 400,
                    'response' => [
                        'title' => 'Account is Blocked!',
                        'message' => 'Your account is temporarily blocked due to 3 failed login attempts. Recover it <a href="'.route('RecoverView').'">here.</a>',
                        'icon' => 'warning'
                    ]
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
