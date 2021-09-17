<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin_user;
use App\Models\Admin_role;
use App\Models\Admin_module;
use App\Models\Admin_module_permission;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data['mainSuperAdminMenu'] = 'AdminUser';
        $data['superadminSubMenu'] = 'adminUser';

        $data['admin_users'] = Admin_user::join('admin_roles', 'admin_roles.id', '=', 'admin_users.role_id')              
        ->get(['admin_users.*', 'admin_roles.role','admin_roles.id as role_id']);
        return view('superadmin.admin-user.admin-user-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['mainSuperAdminMenu'] = 'AdminUser';
        $data['superadminSubMenu'] = 'adminUser';
        $data['roles'] = Admin_role::get();
        return view('superadmin.admin-user.add-admin-user',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->input();
        $request->validate([
            'username' => 'required',
            'email' => 'required|unique:admin_users|email',
            'phone' => 'required|numeric',
            'institute' => 'required',
            'adminRole' => 'required',
            'salt' => 'required',
            'password' => 'required|min:6',
            
          ]);

          $hashed = Hash::make($request->password);  

          $data = array(
              'username'=>$request->username,
              'email'=>$request->email,
              'phone'=>$request->phone,
              'institute'=>$request->institute,
              'role_id'=>$request->adminRole,
              'password'=>$hashed,
              'ip_address'=>$request->ip(),
              'salt'=>$request->salt
          );

          $res = Admin_user::create($data);

          $admin_id = $res->id;

          if($res)
          {

                if($request->adminRole == 1)
                {
                    $modules = Admin_module::where(['role_id'=>$request->adminRole])->get();
                    if(!empty($modules))
                    {
                        foreach($modules as $module)
                        {
                            $superpermission = array(
                                'admin_id'=>$admin_id,
                                'module_id'=>$module->id,
                                'permission'=>'delete',
                                
                            );

                            Admin_module_permission::create($superpermission);
                        }
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
        $data['mainSuperAdminMenu'] = 'AdminUser';
        $data['superadminSubMenu'] = 'adminUser';
        $data['roles'] = Admin_role::get();
        $data['adminUser'] =  Admin_user::where(['id'=>$id])->first();

        return view('superadmin.admin-user.view-admin-user',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['mainSuperAdminMenu'] = 'AdminUser';
        $data['superadminSubMenu'] = 'adminUser';
        $data['roles'] = Admin_role::get();
        $data['adminUser'] =  Admin_user::where(['id'=>$id])->first();

        return view('superadmin.admin-user.edit-admin-user',$data);
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
