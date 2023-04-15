<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\Admin;
// use Image;
use Intervention\Image\Facades\Image;


class AdminController extends Controller
{
    public function dashboard(){
    	return view('admin.dashboard');
    }
    public function updateAdminPassword(Request $request){
        // echo "<pre>"; print_r(Auth::guard('admin')->user()); die;
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
                if($data['confirm_password']==$data['new_password'])
                {
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message', 'Password has been
                    updated successfully!');
                }
                else{
                    return redirect()->back()->with('error_message','New and confirm password are not match!');
                }
            }else{
                return redirect()->back()->with('error_message','Your current password is incurrent!');
            }
        }
        $adminDetails = Admin::where( 'email' ,Auth::guard('admin')->user()->email )->first()-> toArray();

        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));

    }
   
    public function checkAdminPassword(Request $request){
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }
    }
    
    public function updateAdminDetails(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

        $rules=[
            'admin_name'     => 'required|regex:/^[\pL\s\-]+$/u',
            'admin_mobile'=> 'required|numeric'   
        ];
        $customMessages = [
            'admin_name.required'=>'name is required',
            'admin_name.regex'=>'Valid name is required',
            'admin_mobile.required'=>'mobile is required', 
            'admin_mobile.numeric'=>'Valid mobile is required',
       ];
        $this->validate($request,$rules, $customMessages);
        
        //update admin photo
        if($request->hasFile('admin_image')){
            $image_tmp = $request->file('admin_image');
            if($image_tmp->isValid()){
                //get img extension
                $extension = $image_tmp->getClientOriginalExtension();
                //generate new img name
                $imageName = rand(111,99999).'.'.$extension;
                $imagePath = 'admin/images/photos/'.$imageName;
                //upload img
                Image::make($image_tmp)->save($imagePath);
            }
        }else if(!empty($data['current_admin_image'])){
            $imageName = $datal['current_admin_image'];
          }else{
            $imageName = " ";
          }
            //update admin details
            Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=> $data['admin_name'],'mobile'=>$data['admin_mobile'], 'image'=>$imageName]);

            return redirect()->back()->with('success_message','Admin details updated successfully!');
        }
        return view('admin.settings.update_admin_details');
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
