<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ViewUploadsController extends Controller
{
    public function view($id){

        $doc_details = DB::table('premium_application')->where('pa_id',$id)->first();

        if(str_contains($doc_details->pa_file,'.pdf')){
            return view('Reports.ViewUploads.PDF', compact('doc_details'));
        }
        else if(str_contains($doc_details->pa_file,'.jpg')){
            return view('Reports.ViewUploads.Image', compact('doc_details'));
        }
        else if(str_contains($doc_details->pa_file,'.png')){
            return view('Reports.ViewUploads.Image', compact('doc_details'));
        }
        else{
            echo "Unsupported File!";
        }
    }

    public function view_resume($id){
        $doc_details = DB::table('job_application')->where('ja_id', $id)->first();

        return view('Reports.ViewUploads.Resume', compact('doc_details'));
    }
}
