<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    //
    public function index(){
        $data = Department::paginate(10);
        return view('admin.departments', ['dept'=>$data]);
    }

    public function edit(Request $request){

        $value = Department::find($request->id);
        $status="";

        if(isset($request->name)){
            $value->name = $request->name;
            $value->save();
            $status="Record $value->id updated";
            return redirect('admin/deptedit/'.$value->id)->with('status',$status);
        }

        return view('admin.deptedit', [
            "user"=>$value
        ])->with('status',$status);

    }

    public function delete($id){
        $value = Department::find($id);
        $value->delete();

        return redirect('admin/departments');
    }

}
