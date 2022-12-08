<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class JobPostController extends Controller
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

        $jc = DB::table('job_category')->orderBy('jc_category')->get();
        $ajp = DB::table('job_post as j')
            ->select('j.*', 'bp.prov_name', 'bm.mun_name', 'bb.brgy_name', 'a.acc_biz_name', 'a.acc_biz_logo')
            ->leftjoin('accounts as a', 'j.jp_acc_id', 'a.acc_id')
            ->leftjoin('address as add', 'a.acc_biz_add_id', 'add.add_id')
            ->leftjoin('province as bp', 'add.add_prov', 'bp.prov_code')
            ->leftjoin('municipality as bm', 'add.add_mun', 'bm.mun_code')
            ->leftjoin('barangay as bb', 'add.add_brgy', 'bb.brgy_code')
            ->where('j.jp_is_deleted', '0')
            ->where('j.jp_title', $title_operator, '%'.$title.'%')
            ->where('j.jp_category', $category_operator, $category)
            ->where('j.jp_salary', $af_salary_min_operator, $salary_min)
            ->where('j.jp_salary', $af_salary_max_operator, $salary_max)
            ->paginate(6);

        return view('Admin.JobPost', compact(
            'jc', 'ajp', 'title', 'category', 'salary_min', 'salary_max'
        ));
    }
}
