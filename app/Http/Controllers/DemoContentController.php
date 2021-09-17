<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\S3bucket;
use App\Models\Re_s3bucket;
use App\Models\Demo_content;

class DemoContentController extends Controller
{
    public function index(Request $request,$prod_id,$cat_id)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 

        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'demoproductList';
        

        if( isset($_GET['query']) && strlen($_GET['query']) > 1){

            $search_text = $_GET['query'];
           

            $data['contents'] = Demo_content::where('re_s3buckets.filename','LIKE','%'.$search_text.'%')
            ->where(['demo_contents.admin_id'=>$admin_id,'demo_contents.product_id'=>$prod_id,'demo_contents.cat_id'=>$cat_id])            
            ->join('re_s3buckets', 'demo_contents.video_id', '=', 're_s3buckets.etag')                                                                       
            ->paginate(10, ['re_s3buckets.*','demo_contents.id as content_id','demo_contents.sort_order']);           
            
            
        }else{
            $data['contents'] = Demo_content::where(['demo_contents.admin_id'=>$admin_id,'demo_contents.product_id'=>$prod_id,'demo_contents.cat_id'=>$cat_id])            
            ->join('re_s3buckets', 'demo_contents.video_id', '=', 're_s3buckets.etag')                                                                       
            ->paginate(10, ['re_s3buckets.*','demo_contents.id as content_id','demo_contents.sort_order']);

            // dd($data['contents']);

          
        }
        return view('admin.demo-content.content-list',$data);
    }

    public function create(Request $request)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'demoproductList';
        $data['videos'] = Re_s3bucket::where(['admin_id'=>$admin_id])->get();
        // dd($data['videos']);
        return view('admin.demo-content.add-content',$data);
    }

    public function store(Request $request,$prod_id,$cat_id)
    {
        
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $request->validate([
            'video_tag'=>'required',
           
        ]);

        
       $video_tags =  $request->video_tag;
        /* Store data name in DATABASE from HERE */

        if(!empty($video_tags))
        {
            foreach($video_tags as $video_tag)
            {
                $_sortOrder = Demo_content::get()->last();
                if(empty($_sortOrder))
                {
                    $sort_order = 1;
                }else{
                   $sort_order =  $_sortOrder->sort_order +1;
                }

                $data = array( 
                    'product_id'=>$prod_id,  
                    'cat_id'=>$cat_id,    
                    'admin_id'=>$admin_id,
                    'video_id'=>$video_tag,                   
                    'sort_order'=>$sort_order,     
                                  
                );

                $res = Demo_content::create($data);	
            }
        }

        return back()
            ->with('success', 'Content Has Been Added!.');  
       
    }

    public function destroy($id)
    {
        $delete = Demo_content::where(['id'=>$id])->first();
        
       
        Demo_content::where(['id'=>$id])->delete();
         return back()->with('success','Content deleted successfully');
    }

}
