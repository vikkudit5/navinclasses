<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Request;
// use App\Models\LogActivity as LogActivityModel;    
use carbon\carbon;


class Frontend
{

   

    public static function getProductPrice($product_id,$mode)
    {
        
		$prices = DB::table('prices')
            ->where('product_id',$product_id)		
            ->where('mode',$mode)		
		->first();

      

		return $prices;
		
        // return "hello";

    }


    public static function getTeacher($teacher_id)
    {
        
      $teacher = DB::table('admin_users')
              ->where('id',$teacher_id)		
              ->first();       

      return $teacher;

    }

    public static function getTotalProduct($admin_id=2)
    {
        
        $products =DB::table('products as P')
        ->join('main_categories as MC', 'MC.id', '=', 'P.cat_id')  
        ->where(['P.admin_id'=>$admin_id,'p.status'=>'1'])              
        ->select('P.*','MC.name as category')
        ->orderBy('sort_order', 'ASC')
        ->get()->count();     

      return $products;

    }

    public static function getChapter($product_id)
    {
        
        $catetories = DB::table('categories')->where(['product_id'=>$product_id])->get();     

      return $catetories;

    }






	




}

