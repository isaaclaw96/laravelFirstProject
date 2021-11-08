<?php

namespace App\Http\Controllers;

use App\Http\Traits\JsonTrait;
use App\Models\User;
use App\Models\EmployeeJob;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
// use Tymon\JWTAuth\Facades\JWTAuth;



class AdminController extends Controller
{
    //
    public function dashboard(){
        $jwt_token = session('jwt_token');
        $user_count = User::count();
        $dept_count = Department::count();
        $job_count = EmployeeJob::count();

        return view('admin.dashboard',compact('jwt_token','user_count','dept_count','job_count'));
    }
    public function index(Request $request){
        if($request->isMethod('post')){
            $credentials = $request->validate([
                'email' => ['required','email'],
                'password' => ['required'],
            ]);

            if(Auth::attempt($credentials)){
                if(Auth::user()->role ==1){
                    $request->session()->regenerate();
                    $jwt_token =JWTAuth::attempt($credentials);
                    session(['jwt_token' => $jwt_token]);
                    return redirect()->route('dashboard');
                }
                else{
                    return redirect('admin/');
                }
            }
            return back()->withErrors([
                'email'=> 'The provided credentials do not match our records.',
            ]);
            }
            return view('admin.login');
        }

    public function logout(){
        if(Auth::check()){
            Auth::logout();
        }
        return redirect('login');
    }

}

