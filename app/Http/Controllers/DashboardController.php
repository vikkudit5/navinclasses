<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin_module;
use App\Helpers\PermissionActivity;

class DashboardController extends Controller
{
    public function show(Request $req)
    {
        // $userId = $req->session()->get('loggedIn');  
        // dd($userId);
        $data['mainMenu'] = 'dashboard';
        $data['subMenu'] = 'dashboard';
        
        $modules = Admin_module::get();

        return view('admin.dashboard.dashboard',$data);
    }
}
