<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin_module;
use App\Models\Admin_role;

class AdminModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=NULL)
    {
        
        if(!empty($id))
        {
            $data['mainSuperAdminMenu'] = 'AdminUser';
            $data['superadminSubMenu'] = 'roles';
            
            $data['role'] = Admin_role::where(['id'=>$id])->first();
            $data['modules'] = Admin_module::where(['role_id'=>$id])->get();
            // return view('superadmin.modules.module-list',$data);

        }else{

            $data['mainSuperAdminMenu'] = 'AdminUser';
            $data['superadminSubMenu'] = 'modules';
            $data['role'] = '';
            $data['modules'] = Admin_module::get();
            
        }
        return view('superadmin.modules.module-list',$data);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($role_id)
    {
        $data['mainSuperAdminMenu'] = 'AdminUser';
        $data['superadminSubMenu'] = 'modules';
        return view('superadmin.modules.add-module',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$role_id)
    {
        $admin_id = "2";
        $request->validate([
            'moduleName' => 'required',
            
          ]);

          $data = array(
              'admin_id'=>$admin_id,
            'role_id' => $request->role_id,
            'module' => $request->moduleName,
          );

        //   dd($data);

          $res = Admin_module::create($data);

          if($res)
          {
              return back()->with('success', $request->moduleName.' Added successfully!');

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
    public function show($id,$role_id)
    {
        $data['mainSuperAdminMenu'] = 'AdminUser';
        $data['superadminSubMenu'] = 'modules';
        $data['role'] = Admin_role::where(['id'=>$role_id])->first();
       $data['module'] =  Admin_module::where(['id'=>$id])->first();
        return view('superadmin.modules.view-module',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$role_id)
    {
        $data['mainSuperAdminMenu'] = 'AdminUser';
        $data['superadminSubMenu'] = 'modules';
        $data['role'] = Admin_role::where(['id'=>$role_id])->first();
       $data['module'] =  Admin_module::where(['id'=>$id])->first();
        return view('superadmin.modules.edit-module',$data);
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
        $request->validate([
            'moduleName' => 'required',
            
          ]);

         $data = array(
            'module' => $request->moduleName,
         );

         $res = Admin_module::where(['id'=>$id])->update($data);

        //  dd($res);

          if($res)
          {
              return back()->with('success', $request->moduleName.' Updated successfully!');

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
        Admin_module::where(['id'=>$id])->delete();
        return back()->with('success','Delete Successfully!');
    }
}
