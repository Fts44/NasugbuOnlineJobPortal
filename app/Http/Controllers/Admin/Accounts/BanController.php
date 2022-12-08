<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class BanController extends Controller
{
    public function ban($id){
        DB::table('accounts')
            ->where('acc_id', $id)
            ->update([
                'acc_banned_status' => 1
            ]);

        $response = [
            'title' => 'Success!',
            'message' => 'The account was disabled.',
            'icon' => 'success',
            'status' => 200
        ];  

        return (object)$response;
    }

    public function unban($id){
        DB::table('accounts')
            ->where('acc_id', $id)
            ->update([
                'acc_banned_status' => 0
            ]);

        $response = [
            'title' => 'Success!',
            'message' => 'The account was enabled.',
            'icon' => 'success',
            'status' => 200
        ];  

        return (object)$response;
    }
}
