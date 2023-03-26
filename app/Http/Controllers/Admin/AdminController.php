<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    public function dashboard(){
    	return view('admin.dashboard');
    }
    public function login(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data= $request->all();
            // echo "<pre>"; print_r($data); die;

            // $validated = $request->validate([
            //     'email' => 'required|email|max:255',
            //     'password' => 'required',
            // ]);
            $rules=[
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];
            $customMessages = [
                 'email.requires'=>'Email is required',
                 'email.email'=>'Valid email is required',
                 'password.requires'=>'Password is required',
            ];

            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1])){
                    return redirect('admin/dashboard');
                }else{
                    return redirect()->back()->with('error_message','Invalid email or password');
            }
        }
    	return view('admin.login');
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
