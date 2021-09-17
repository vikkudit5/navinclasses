<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin_user;
use App\Models\Admin_module_permission;
use App\Models\Admin_module;

class SubadminPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($admin_id)
    {
        
        
        $data['mainMenu'] = 'subadmin';
        $data['subMenu'] = 'subadminUserList';
        
        $data['admin_modules'] = Admin_module_permission::join('admin_modules', 'admin_modules.id', '=', 'admin_module_permissions.module_id')  
            ->where(['admin_module_permissions.admin_id'=>$admin_id])            
        ->get(['admin_module_permissions.*', 'admin_modules.module']);
        $data['admin_user'] = Admin_user::where(['id'=>$admin_id])->first();

        // dd($data['admin_users']);

        return view('admin.module-permission.module-permission',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$user_id)
    {
       
        $admin_id = $request->session()->get('loggedIn')['id'];
        

        $data['modules'] = Admin_module::join('admin_module_permissions', 'admin_module_permissions.module_id', '=', 'admin_modules.id')    
        ->where(['admin_module_permissions.admin_id'=>$admin_id])          
        ->get(['admin_modules.*']);


        $data['mainMenu'] = 'subadmin';
        $data['subMenu'] = 'subadminUserList';
        return view('admin.module-permission.add-module-permission',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$user_id)
    {
        
        $request->validate([
                     
            'adminModuleId' => 'required',
            'permission' => 'required',
           
            
          ]);

          $modules = $request->adminModuleId;

         if(!empty($modules))
         {
             foreach($modules as $module)
             {
                $checkModulePermission = Admin_module_permission::where(['admin_id'=>$request->adminUserId,'module_id'=>$module])->first();

                if(empty($checkModulePermission))
                {
                    $data = array(
                        'admin_id'=>$user_id,
                        'module_id'=>$module,
                        'permission'=>$request->permission,
                        
                    );
          
                    $res = Admin_module_permission::create($data);
                }else{
                    
                    $data = array(                       
                        
                        'permission'=>$request->permission,
                        
                    );
          
                    $res = Admin_module_permission::where(['admin_id'=>$request->adminUserId,'module_id'=>$module])->update($data);
                }

               
             }
         }

         return back()->with('success','Permission Added successfully!');

        //  return redirect('admin/module-permission/'.$request->adminUserId)->with('success','Permission Added successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['mainMenu'] = 'AdminUser';
        $data['subMenu'] = 'adminUser';

        $data['admin_users'] = Admin_user::get();
        $data['modules'] = Admin_module::get();
        $data['modulePermission'] = Admin_module_permission::where(['id'=>$id])->first();
       

        return view('admin.module-permission.edit-module-permission',$data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin_module_permission::where(['id'=>$id])->delete();
        return back()->with('success','Delete Successfully!');
    }
}
