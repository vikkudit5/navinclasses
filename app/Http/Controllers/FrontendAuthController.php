<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendAuthController extends Controller
{
    public function signUp()
    {
        $admin_id = 2;
        $data['title'] = 'Navin Classes|Home';
        $data['frontMenu'] = 'home';

        return view('register',$data);
    }

    public function saveSignUp(Request $request)
    {
        
    }
}
