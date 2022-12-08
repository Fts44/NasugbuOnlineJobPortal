<?php

namespace App\Http\Controllers\Admin\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;

class JobCategoryController extends Controller
{
    public function index(){
        $jc = DB::table('job_category as jc')
            ->select('jc.*')
            ->orderBy('jc.jc_category')
            ->get();

        return view('Admin.Configuration.JobCategory', compact(
            'jc'
        ));
    }

    public function insert(Request $request){
        $rules = [
            'job_category' => ['required'],
            'category_status' => ['required']
        ];
        $validator = validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'title' => 'Error',
                'message' => 'Job Category not inserted',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            try{
                DB::table('job_category')
                    ->insert([
                        'jc_category' => $request->job_category,
                        'jc_status' => $request->category_status
                    ]);

                $response = [
                    'title' => 'Success',
                    'message' => 'Job Category inserted',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){

            }
        }
        return (object)$response;
    }

    public function update(Request $request, $id){
        $rules = [
            'job_category' => ['required', 'unique:job_category,jc_category,'.$id.',jc_id'],
            'category_status' => ['required']
        ];
        $validator = validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'title' => 'Error',
                'message' => 'Job Category not inserted',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            try{
                DB::table('job_category')
                    ->where('jc_id', $id)
                    ->update([
                        'jc_category' => $request->job_category,
                        'jc_status' => $request->category_status
                    ]);

                $response = [
                    'title' => 'Success',
                    'message' => 'Job Category updated',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(Exception $e){

            }
        }
        return (object)$response;
    }

    public function delete($id){
        try{
            DB::table('job_category')
                ->where('jc_id', $id)
                ->delete();
            $response = [
                'title' => 'Success',
                'message' => 'Job Category deleted',
                'icon' => 'success',
                'status' => 200
            ];
        }
        catch(Exception $e){

        }
        return (object)$response;
    }
}
