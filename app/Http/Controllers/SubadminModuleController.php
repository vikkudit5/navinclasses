<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin_module;
use App\Models\Admin_role;
use App\Models\Subadmin_module;

class SubadminModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$role_id)
    {

        $data['mainMenu'] = 'subadmin';
        $data['subMenu'] = 'subadminRoleList';
       
        $admin_id = $request->session()->get('loggedIn')['id'];

            $data['role'] = Admin_role::where(['id'=>$role_id])->first();
           

            $data['admin_modules'] = Admin_module::join('subadmin_modules', 'admin_modules.id', '=', 'subadmin_modules.module_id')  
            ->where(['subadmin_modules.admin_id'=>$admin_id,'subadmin_modules.role_id'=>$role_id])            
        ->get(['admin_modules.*']);

            // return view('superadmin.modules.module-list',$data);

     
        return view('admin.subadmin-module.submodule-list',$data);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$role_id)
    {
        $data['mainMenu'] = 'subadmin';
        $data['subMenu'] = 'subadminRoleList';

        $admin_id = $request->session()->get('loggedIn')['id'];

        $data['modules'] = Admin_module::join('admin_module_permissions', 'admin_module_permissions.module_id', '=', 'admin_modules.id')    
        ->where(['admin_module_permissions.admin_id'=>$admin_id])          
        ->get(['admin_modules.*']);
        return view('admin.subadmin-module.add-submodule',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$role_id)
    {
        $admin_id = $request->session()->get('loggedIn')['id'];
        $request->validate([
            'adminModuleId' => 'required',
            
          ]);

         

        //   dd($data);

        $modules = $request->adminModuleId;

        if(!empty($modules))
        {
            foreach($modules as $module)
            {
                $data = array(
                    'role_id' => $role_id,
                    'admin_id'=>$admin_id,
                    'module_id' => $module,
                  );
                  $res = Subadmin_module::create($data);
            }
        }


        return back()->with('success', 'Module Added successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$role_id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
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
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subadmin_module::where(['id'=>$id])->delete();
        return back()->with('success','Delete Successfully!');
    }
}
