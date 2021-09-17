<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class FrontendController extends Controller
{
    public function index()
    {
        $admin_id = 2;
        $data['title'] = 'Navin Classes|Home';
        $data['frontMenu'] = 'home';

        $data['products'] =DB::table('products as P')
                ->join('main_categories as MC', 'MC.id', '=', 'P.cat_id')  
                ->where(['P.admin_id'=>$admin_id,'P.status'=>'1'])              
                ->select('P.*','MC.name as category')
                ->orderBy('sort_order', 'ASC')
                ->get();

                // dd($data['products']);

        return view('home',$data);
    }

    public function courseList()
    {
        $admin_id = 2;
        $data['title'] = 'Navin Classes|course-list';
        $data['frontMenu'] = 'home';
        $data['hello'] = 'home';

        $data['products'] =DB::table('products as P')
                ->join('main_categories as MC', 'MC.id', '=', 'P.cat_id')  
                ->where(['P.admin_id'=>$admin_id,'P.status'=>'1'])              
                ->select('P.*','MC.name as category')
                ->orderBy('sort_order', 'ASC')
                ->paginate(10);

                // dd($data['products']);

        return view('course-list',$data);
    }

    public function courseGrid()
    {
        $admin_id = 2;
        $data['title'] = 'Navin Classes|Course-grid';
        $data['frontMenu'] = 'home';

        $data['products'] =DB::table('products as P')
                ->join('main_categories as MC', 'MC.id', '=', 'P.cat_id')  
                ->where(['P.admin_id'=>$admin_id,'P.status'=>'1'])              
                ->select('P.*','MC.name as category')
                ->orderBy('sort_order', 'ASC')
                ->paginate(10);

                // dd($data['products']);

        return view('course-grid',$data);
    }

    public function courseDetails($seourl)
    {
        $admin_id = 2;
        $data['title'] = 'Navin Classes|course-details';
        $data['frontMenu'] = 'home';

        $data['product'] =DB::table('products as P')
                ->join('main_categories as MC', 'MC.id', '=', 'P.cat_id')  
                ->where(['P.admin_id'=>$admin_id,'P.status'=>'1','p.slug'=>$seourl]) 
                ->select('P.*','MC.name as category')
                ->first();

                // dd($data['products']);

        return view('course-details',$data);
    }





}
