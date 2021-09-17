<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin_module;
use App\Helpers\PermissionActivity;

class SuperadminDashboardController extends Controller
{
    public function show(Request $req)
    {
        // $userId = $req->session()->get('loggedIn');  
        // dd($userId);
        $data['mainSuperAdminMenu'] = 'superadmin-dashboard';
        $data['superadminSubMenu'] = 'dashboard';
        
        $modules = Admin_module::get();

        return view('superadmin.dashboard.dashboard',$data);
    }
}
