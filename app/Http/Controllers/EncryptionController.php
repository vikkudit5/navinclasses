<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin_user;

class EncryptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['mainMenu'] = 'encryption';
        $data['subMenu'] = 'encryptionList';
        $data['admin_users'] = Admin_user::join('admin_roles', 'admin_roles.id', '=', 'admin_users.role_id') 
        ->where(['role_id'=>3])             
        ->get(['admin_users.*', 'admin_roles.role']);
        return view('admin.encryption.encryption-user-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['mainMenu'] = 'encryption';
        $data['subMenu'] = 'encryptionList';
       
        return view('admin.encryption.add-encryption-user',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|unique:admin_users|email',
            'phone' => 'required|numeric',           
            'password' => 'required|min:6',
            
          ]);

          $hashed = Hash::make($request->password);  
          $getSalt = Admin_user::where(['id'=>$admin_id])->first();
          $data = array(
              'role_id'=>3,
              'username'=>$request->username,
              'email'=>$request->email,
              'phone'=>$request->phone,            
              'password'=>$hashed,
              'salt'=>$getSalt->salt,
              'ip_address'=>$request->ip()
          );

          $res = Admin_user::create($data);

          if($res)
          {
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
        $data['mainMenu'] = 'encryption';
        $data['subMenu'] = 'encryptionList';
       
        $data['adminUser'] =  Admin_user::where(['id'=>$id])->first();

        return view('admin.encryption.view-encryption-user',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['mainMenu'] = 'encryption';
        $data['subMenu'] = 'encryptionList';
        
        $data['adminUser'] =  Admin_user::where(['id'=>$id])->first();

        return view('admin.encryption.edit-encryption-user',$data);
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
            'salt' => 'required',
            'phone' => 'required|numeric',
            
            
            
          ]);

          

          $data = array(
              'username'=>$request->username,
              'email'=>$request->email,
              'phone'=>$request->phone,       
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
