<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['mainMenu'] = 'userManagement';
        $data['subMenu'] = 'userList';
        

        if( isset($_GET['query']) && strlen($_GET['query']) > 1){

            $search_text = $_GET['query'];
            // dd($search_text);
            $data['users'] = DB::table('users')->where('name','LIKE','%'.$search_text.'%')->paginate(10);
           
            return view('admin.user.user-list',$data);
            
        }else{
            $data['users'] = DB::table('users')->paginate(10);

          
            return view('admin.user.user-list',$data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['mainMenu'] = 'userManagement';
        $data['subMenu'] = 'userList';

        
        return view('admin.user.add-user',$data);
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
            'username' => 'required',
            'email' => 'required|unique:users|email',
            'phone' => 'required|numeric',            
            'password' => 'required|min:6',
            'cpassword' => 'required_with:password|same:password|min:6'
            
          ]);

          $hashed = Hash::make($request->password);  

          $data = array(
              'admin_id'=>$admin_id,
              'user_unique_id'=>time().uniqid(),
              'name'=>$request->username,
              'email'=>$request->email,
              'phone'=>$request->phone,             
              'password'=>$hashed,
              'ip_address'=>$request->ip()
          );

          $res = User::create($data);

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
        
        $data['mainMenu'] = 'userManagement';
        $data['subMenu'] = 'userList';

        $data['users'] = User::where(['id'=>$id])->first();
        return view('admin.user.view-user',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['mainMenu'] = 'userManagement';
        $data['subMenu'] = 'userList';

        $data['users'] = User::where(['id'=>$id])->first();
        return view('admin.user.edit-user',$data);
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
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric',
         
            
            
          ]);

          

          $data = array(
              'name'=>$request->name,
              'email'=>$request->email,
              'phone'=>$request->phone,
             
              'ip_address'=>$request->ip()
          );

          $res = User::where(['id'=>$id])->update($data);

          if($res)
          {
              return back()->with('success', $request->name.' Added successfully!');

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
        User::where(['id'=>$id])->delete();
         return back()->with('success',' deleted successfully');
    }
}
