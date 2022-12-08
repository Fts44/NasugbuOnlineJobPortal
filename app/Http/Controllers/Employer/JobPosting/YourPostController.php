<?php

namespace App\Http\Controllers\Employer\JobPosting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class YourPostController extends Controller
{
    public function index(Request $request){
        $title = $request->af_title;
        $title_operator = ($request->af_title) ? 'LIKE' : '<>';

        $category = $request->af_category;
        $category_operator = ($request->af_category) ? '=' : '<>'; 

        $salary_min = $request->af_salary_min;
        $af_salary_min_operator = ($request->af_salary_min) ? '>=' : '<>';

        $salary_max = $request->af_salary_max;
        $af_salary_max_operator = ($request->af_salary_max) ? '<=' : '<>';

        $jc = DB::table('job_category')
            ->orderBy('jc_category')
        ->get();
        
        $yjp = DB::table('job_post as j')
            ->select('j.*', 'jc.*', 'bp.prov_name', 'bm.mun_name', 'bb.brgy_name', 'a.acc_biz_name', 'a.acc_biz_logo')
            ->leftjoin('accounts as a', 'j.jp_acc_id', 'a.acc_id')
            ->leftjoin('address as add', 'a.acc_biz_add_id', 'add.add_id')
            ->leftjoin('province as bp', 'add.add_prov', 'bp.prov_code')
            ->leftjoin('municipality as bm', 'add.add_mun', 'bm.mun_code')
            ->leftjoin('barangay as bb', 'add.add_brgy', 'bb.brgy_code')
            ->leftjoin('job_category as jc', 'jc.jc_id', 'j.jp_category')
            ->where('a.acc_id', Session('user_id'))
            ->where('j.jp_is_deleted', '0')
            ->where('j.jp_title', $title_operator, '%'.$title.'%')
            ->where('j.jp_category', $category_operator, $category)
            ->where('j.jp_salary', $af_salary_min_operator, $salary_min)
            ->where('j.jp_salary', $af_salary_max_operator, $salary_max)
            ->orderBy('jp_id', 'DESC')
        ->paginate(6);

        return view('Employer.JobPost.YourPosting', compact(
            'jc', 'yjp', 'title', 'category', 'salary_min', 'salary_max'
        ));
        
    }

    public function insert(Request $request){
        $rules = [
            'available_post' => ['required', 'not_in:0'],
            'category' => ['required'],
            'title' => ['required'],
            'description' => ['required'],
            'qualification' => ['required'],
            'salary' => ['required']
        ];

        $messages = [
            'available_post.not_in' => 'The available post for today is maxed out.'
        ];

        $validator = validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Error',
                'message' => 'Job Post not added',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            try{
                DB::table('job_post')->insert([
                    'jp_category' => $request->category,
                    'jp_title' => $request->title,
                    'jp_description' => $request->description,
                    'jp_qualification' => $request->qualification,
                    'jp_salary' => $request->salary,
                    'jp_acc_id' => Session('user_id')
                ]);

                $response = [
                    'title' => 'Success',
                    'message' => 'Job Post added',
                    'icon' => 'success',
                    'status' => 200,
                ];
            }   
            catch(Exception $e){

            }
        }
        return (object)$response;
    }

    public function retrieve($id){

        $jp = DB::table('job_post as jp')
            ->leftjoin('accounts as a', 'jp.jp_acc_id', 'a.acc_id')
            ->where('jp.jp_id', $id)->first();

        echo json_encode($jp);
    }

    public function update(Request $request){
        $rules = [
            'category' => ['required'],
            'title' => ['required'],
            'description' => ['required'],
            'qualification' => ['required'],
            'salary' => ['required']
        ];

        $validator = validator::make($request->all(), $rules);

        if($validator->fails()){
            $response = [
                'title' => 'Error',
                'message' => 'Job Post not updated',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }
        else{
            try{
                DB::table('job_post')
                    ->where('jp_id', $request->jp_id)
                    ->update([
                    'jp_category' => $request->category,
                    'jp_title' => $request->title,
                    'jp_description' => $request->description,
                    'jp_qualification' => $request->qualification,
                    'jp_salary' => $request->salary,
                ]);

                $response = [
                    'title' => 'Success',
                    'message' => 'Job Post updated',
                    'icon' => 'success',
                    'status' => 200,
                ];
            }   
            catch(Exception $e){

            }
        }
        return (object)$response;
    }

    public function delete($id){
        try{
            DB::table('job_post')->where('jp_id', $id)->delete();

            $response = [
                'title' => 'Success',
                'message' => 'Job Post deleted',
                'icon' => 'success',
                'status' => 200,
            ];
        }
        catch(Exception $e){
           
        }
    
        return (object)$response;
    }
}
