<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin_role;

class SubadminRoleController extends Controller
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
        $data['subMenu'] = 'subadminRoleList';

        $data['roles'] = Admin_role::where(['admin_id'=>$admin_id])->get();
        return view('admin.subadmin-roles.role-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['mainMenu'] = 'subadmin';
        $data['subMenu'] = 'subadminRoleList';
        return view('admin.subadmin-roles.add-role',$data);
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

        $request->validate([
            'rollName' => 'required',
            
          ]);

          $res = Admin_role::create([
            'admin_id' => $admin_id,
            'role' => $request->rollName,
            
          ]);

          if($res)
          {
              return back()->with('success', $request->rollName.' Added successfully!');

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
        $data['subMenu'] = 'subadminRoleList';
       $data['role'] =  Admin_role::where(['id'=>$id])->first();
        return view('admin.subadmin-roles.view-role',$data);
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
        $data['subMenu'] = 'subadminRoleList';
       $data['role'] =  Admin_role::where(['id'=>$id])->first();
        return view('admin.subadmin-roles.edit-role',$data);
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
            'rollName' => 'required',
            
          ]);

         $data = array(
            'role' => $request->rollName,
         );

         $res = Admin_role::where(['id'=>$id])->update($data);

        //  dd($res);

          if($res)
          {
              return back()->with('success', $request->rollName.' Updated successfully!');

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
        
        Admin_role::where(['id'=>$id])->delete();
        return back()->with('success','Delete Successfully!');
    }
}
