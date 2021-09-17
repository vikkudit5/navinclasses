<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\Admin_user;
use Validator;

class AuthController extends Controller
{
    public function superAdminlogin()
    {
        return view('superadmin.login');
    }

    public function superAdminMakeLogin(Request $Request)
    {
        // dd($Request->input());
        $validator = Validator::make($Request->all(),[
            'password'=>"required",
            'email'=>"required"
        ]);

        if($validator->fails())
        {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $data = array(

            'email'=>$Request->email,
            'password'=>$Request->password,
            'role_id'=>'1',
        );

        // dd($data);

        if(Auth::guard('admin')->attempt($data))
        {
            $res = Admin_user::where(['email'=>$Request->email])->first();
            // dd($res);

            $data = ['id'=>$res->id,'username'=>$res->username,'email'=>$res->email,'role_id'=>$res->role_id,'phone'=>$res->phone];
 
            $Request->session()->put('loggedIn', $data);
            return redirect('superadmin/dashboard');
        }else{
            return back()->with('error','invalid Email Or Password!');
        }
    }


    public function login()
    {
        return view('admin.login');
    }

    public function makeLogin(Request $Request)
    {
        // dd($Request->input());
        $validator = Validator::make($Request->all(),[
            'password'=>"required",
            'email'=>"required"
        ]);

        if($validator->fails())
        {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $data = array(

            'email'=>$Request->email,
            'password'=>$Request->password,
            // 'role_id'=>'2',
        );

        // dd($data);

        if(Auth::guard('admin')->attempt($data))
        {
            $res = Admin_user::where(['email'=>$Request->email])->first();
            // dd($res);

            $data = ['id'=>$res->id,'username'=>$res->username,'email'=>$res->email,'role_id'=>$res->role_id,'phone'=>$res->phone];
 
            $Request->session()->put('loggedIn', $data);
            return redirect('admin/dashboard');
        }else{
            return back()->with('error','invalid Email Or Password!');
        }
    }

    public function resetPassword($id)
    {
        $data['mainMenu'] = 'subadmin';
        $data['subMenu'] = 'subadminUserList';

        return view('admin.subadmin.reset-password',$data);
    }

    public function updateResetPassword(Request $request,$id)
    {
        $request->validate([
            
            'password' => 'required|min:6',            
            'cpassword' => 'required_with:password|same:password|min:6'
            
          ]);

          $hashed = Hash::make($request->password); 

          $data = array(
           
            'password'=>$hashed,
            
        );

        $res = Admin_user::where(['id'=>$id])->update($data);
        if($res)
        {
            return back()->with('success', 'Password Reset successfully!');
        }else{
            return back()->with('error', 'Something Went Wrong!');
        }

    }

    public function logout(Request $req)
    {
        Auth::logout();

        $req->session()->invalidate();

        $req->session()->regenerateToken();

        return redirect('/admin-login');
    }
}
