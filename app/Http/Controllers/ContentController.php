<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\S3bucket;
use App\Models\Re_s3bucket;
use App\Models\Content;
use App\Models\Mcq;
use App\Models\Pdf_test;
use App\Models\Ebook;

class ContentController extends Controller
{
    public function index(Request $request,$prod_id,$cat_id)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 

        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'productList';
        

        if( isset($_GET['query']) && strlen($_GET['query']) > 1){

            $search_text = $_GET['query'];
           

            $data['contents'] = Content::where('re_s3buckets.filename','LIKE','%'.$search_text.'%')
            ->where(['contents.admin_id'=>$admin_id,'contents.product_id'=>$prod_id,'contents.cat_id'=>$cat_id])            
            ->join('re_s3buckets', 'contents.video_id', '=', 're_s3buckets.etag')                                                                       
            ->paginate(10, ['re_s3buckets.*','contents.id as content_id','contents.sort_order']);           
            return view('admin.content.content-list',$data);
            
        }else{
           
        }

        $data['contents'] = Content::where(['contents.admin_id'=>$admin_id,'contents.product_id'=>$prod_id,'contents.cat_id'=>$cat_id])            
        ->join('re_s3buckets', 'contents.video_id', '=', 're_s3buckets.etag')                                                                       
        ->paginate(10, ['re_s3buckets.*','contents.id as content_id','contents.sort_order']);

        $data['mcqs'] = Content::where(['contents.admin_id'=>$admin_id,'contents.product_id'=>$prod_id,'contents.cat_id'=>$cat_id])            
        ->join('mcqs', 'contents.video_id', '=', 'mcqs.id')                                                                       
        ->paginate(10, ['mcqs.*','contents.id as content_id','contents.sort_order']);

        $data['pdfs'] = Content::where(['contents.admin_id'=>$admin_id,'contents.product_id'=>$prod_id,'contents.cat_id'=>$cat_id])            
        ->join('pdf_tests', 'contents.video_id', '=', 'pdf_tests.etag')                                                                       
        ->paginate(10, ['pdf_tests.*','contents.id as content_id','contents.sort_order']);

        $data['ebooks'] = Content::where(['contents.admin_id'=>$admin_id,'contents.product_id'=>$prod_id,'contents.cat_id'=>$cat_id])            
        ->join('ebooks', 'contents.video_id', '=', 'ebooks.etag')                                                                       
        ->paginate(10, ['ebooks.*','contents.id as content_id','contents.sort_order']);




        // dd($data['mcqs']);

      
        return view('admin.content.content-list',$data);
        
    }

    public function create(Request $request)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'productList';
        $data['videos'] = Re_s3bucket::where(['admin_id'=>$admin_id])->get();
        $data['mcqs'] = Mcq::where(['admin_id'=>$admin_id])->get();
        $data['pdf_tests'] = Pdf_test::where(['admin_id'=>$admin_id])->get();
        $data['ebooks'] = Ebook::where(['admin_id'=>$admin_id])->get();
        // dd($data['mcqs']);
        return view('admin.content.add-content',$data);
    }

    public function store(Request $request,$prod_id,$cat_id)
    {
        
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $request->validate([
            'video_tag'=>'required',
           
        ]);

        
       $video_tags =  $request->video_tag;
       $type =  $request->type;
        /* Store data name in DATABASE from HERE */

        if(!empty($video_tags))
        {
            foreach($video_tags as $video_tag)
            {
                $_sortOrder = Content::get()->last();
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
                    'type'=>$type,
                    'video_id'=>$video_tag,                   
                    'sort_order'=>$sort_order,     
                                  
                );

                $res = Content::create($data);	
            }
        }

        return back()
            ->with('success', 'Content Has Been Added!.');  
       
    }

    public function destroy($id)
    {
        $delete = Content::where(['id'=>$id])->first();
        
       
        Content::where(['id'=>$id])->delete();
         return back()->with('success','Content deleted successfully');
    }

}
