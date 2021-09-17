<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin_user;
use App\Models\Admin_role;
use App\Models\Admin_module;
use App\Models\Admin_module_permission;
use App\Models\Subadmin_module;
use Illuminate\Support\Facades\DB;

class SubadminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin_id = $request->session()->get('loggedIn')['id'];
        $data['mainMenu'] = 'subadmin';
        $data['subMenu'] = 'subadminUserList';

        $data['admin_users'] = Admin_user::join('admin_roles', 'admin_roles.id', '=', 'admin_users.role_id')   
        ->where(['parent_id'=>$admin_id])           
        ->get(['admin_users.*', 'admin_roles.role','admin_roles.id as role_id']);
        return view('admin.subadmin.subadmin-user-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $admin_id = $request->session()->get('loggedIn')['id'];
        $data['mainMenu'] = 'subadmin';
        $data['subMenu'] = 'subadminUserList';
        $data['roles'] = Admin_role::where(['admin_id'=>$admin_id])->get();
        return view('admin.subadmin.add-admin-user',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin_id = $request->session()->get('loggedIn')['id'];
        // return $request->input();
        $request->validate([
            'username' => 'required',
            'email' => 'required|unique:admin_users|email',
            'phone' => 'required|numeric',
            'institute' => 'required',
            'adminRole' => 'required',
            'password' => 'required|min:6',
            
          ]);

          $getSalt = Admin_user::where(['id'=>$admin_id])->first();

          $hashed = Hash::make($request->password);  

          $data = array(
              'parent_id'=>$admin_id,
              'username'=>$request->username,
              'email'=>$request->email,
              'phone'=>$request->phone,
              'institute'=>$request->institute,
              'role_id'=>$request->adminRole,
              'password'=>$hashed,
              'salt'=>$getSalt->salt,
              'ip_address'=>$request->ip()
          );

          $res = Admin_user::create($data);

          $admin_user_id = $res->id;

          if($res)
          {
            
            // DB::enableQueryLog(); // Enable query log

            // Your Eloquent query executed by using get()
            
           

                $modules = Subadmin_module::where(['role_id'=>$request->adminRole,'admin_id'=>$admin_id])->get();
                // dd(DB::getQueryLog()); // Show results of log
                if(!empty($modules))
                {
                    foreach($modules as $module)
                    {
                        $superpermission = array(
                            'admin_id'=>$admin_user_id,
                            'module_id'=>$module->module_id,
                            'permission'=>'delete',
                            
                        );

                        Admin_module_permission::create($superpermission);
                    }
                }
               
            
               
              return back()->with('success', $request->username.' Added successfully!');

          }else{
              return back()->with('error','Something Went Wrong!');
          }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['mainMenu'] = 'subadmin';
        $data['subMenu'] = 'subadminUserList';
        $data['roles'] = Admin_role::get();
        $data['adminUser'] =  Admin_user::where(['id'=>$id])->first();

        return view('admin.subadmin.view-admin-user',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['mainMenu'] = 'subadmin';
        $data['subMenu'] = 'subadminUserList';
         
        $data['roles'] = Admin_role::get();
        $data['adminUser'] =  Admin_user::where(['id'=>$id])->first();

        return view('admin.subadmin.edit-admin-user',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->input();
        $request->validate([
            'username' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric',
            'institute' => 'required',
            'adminRole' => 'required',
            'salt' => 'required',
            
            
          ]);

          

          $data = array(
              'username'=>$request->username,
              'email'=>$request->email,
              'phone'=>$request->phone,
              'institute'=>$request->institute,
              'role_id'=>$request->adminRole,
              'salt'=>$request->salt,
              
              'ip_address'=>$request->ip()
          );

          $res = Admin_user::where(['id'=>$id])->update($data);

          if($res)
          {
              return back()->with('success', $request->username.' Added successfully!');

          }else{
              return back()->with('error','Something Went Wrong!');
          }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin_user::where(['id'=>$id])->delete();
        return back()->with('success','Delete Successfully!');
    }
}
