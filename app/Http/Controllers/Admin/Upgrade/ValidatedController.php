<?php

namespace App\Http\Controllers\Admin\Upgrade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ValidatedController extends Controller
{
    public function index(){
        $validated = DB::table('premium_application as pa')
            ->where('pa_status', '!=',0)
            ->leftjoin('accounts as a', 'pa.acc_id', 'a.acc_id')
        ->get();

        return view('Admin.Upgrade.Validated')
            ->with([
                'validated' => $validated
            ]);
    }

    public function cancel($id){
        DB::table('premium_application')
            ->where('pa_id', $id)
            ->update([
                'pa_validity' => NULL,
                'pa_status' => 0
            ]);

        $response = [
            'title' => 'Success',
            'message' => 'Application respond cancelled',
            'icon' => 'success',
            'status' => 200
        ];

        return (object)$response;
    }
}
