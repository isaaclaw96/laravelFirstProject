<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    //
    public function dashboard(){
        return view('admin.dashboard');
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
                    return redirect()->route('dashboard');
                }
                else{
                    return redirect('admin/login');
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

