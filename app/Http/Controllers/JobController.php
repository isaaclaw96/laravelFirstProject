<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class JobController extends Controller
{
    //
    public function index(){
        $data = Job::paginate(10);
        return view('admin.jobs', ['jobs'=>$data]);
    }

    public function edit(Request $request){

        $value = Job::find($request->id);
        $status="";

        if(isset($request->title) && isset($request->description)){
            $value->title = $request->title;
            $value->description = $request->description;
            $value->min_salary = $request->min_salary;
            $value->max_salary = $request->max_salary;
            $value->save();
            $status="Record $value->id updated";
            return redirect('admin/jobedit/'.$value->id)->with('status',$status);
        }

        return view('admin.jobedit', [
            "user"=>$value
        ])->with('status',$status);

    }

    public function delete($id){
        $value = Job::find($id);
        $value->delete();

        return redirect('admin/jobs');
    }
}
