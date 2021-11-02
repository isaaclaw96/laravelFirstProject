<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function index(){
        $data = User::paginate(10);
        return view('admin.users', ['users'=>$data]);
    }

    public function edit(Request $request){

        $user = User::where('id',$request->id)->first();
        $user = User::whereId($request->id)->first(); //same way with above line
        $status="";

        if(isset($request->name) && isset($request->email)){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            $status="Record $user->id updated";
            return redirect('admin/edituser/'.$user->id)->with('status',$status);
        }

        return view('admin.edituser', [
            "user"=>$user
        ])->with('status',$status);


    }

    public function delete($id){
        $user = User::find($id);
        $user->delete();

        return redirect('admin/users');
    }
}
