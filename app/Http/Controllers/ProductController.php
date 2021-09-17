<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Admin_user;
use App\Models\Main_category;
use File;

class ProductController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'productList';
        $admin_id = $request->session()->get('loggedIn')['id'];
        
        $admin_id = $request->session()->get('loggedIn')['id']; 
        if( isset($_GET['query']) && strlen($_GET['query']) > 1){

            $search_text = $_GET['query'];
            // dd($search_text);
            $data['products'] = DB::table('products')->where('name','LIKE','%'.$search_text.'%')->where(['admin_id'=>$admin_id])->paginate(10);
           
            return view('admin.product.product-list',$data);
            
        }else{
            $data['products'] = DB::table('products')->paginate(10);

          
            return view('admin.product.product-list',$data);
        }


        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'productList';
        $data['categories'] = Main_category::where(['admin_id'=>$admin_id,'parent_id'=>0])->get();
        $data['teachers'] = Admin_user::where(['role_id'=>7])->get();
        return view('admin.product.add-product',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input());
        
        $admin_id = $request->session()->get('loggedIn')['id']; 
        $request->validate([
            'name'=>'required|unique:products',
            'type'=>'required',
            'short_desc'=>'required',
            'description'=>'required',
            'features'=>'required',
            'teacher_id'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        
        $imageName = time().rand().'.'.$request->image->extension();  
     
        $request->image->move(public_path('uploads/products'), $imageName);

        // dd($imageName);

        $slug =  str_replace(' ', '-', strtolower($request->name));
        $_sortOrder = Product::get()->last();
        if(empty($_sortOrder))
        {
            $sort_order = 1;
        }else{
           $sort_order =  $_sortOrder->sort_order +1;
        }
        
        // dd($request->selectCatId);

        $data = array(

            'admin_id'=>$admin_id,
            'cat_id'=>$request->selectCatId,
            'teacher_id'=>$request->teacher_id,
            'name'=>$request->name,
            'type'=>$request->type,
            'short_desc'=>$request->short_desc,
            'description'=>$request->description,
            'video_url'=>$request->videoUrl,
            'features'=>$request->features,
            'image'=>$imageName,
            'slug'=>$slug,
            'sort_order'=>$sort_order,
            'status'=>1,
            
        );

        // dd($data);

        $categoryType = Main_category::where(['id'=>$request->selectCatId])->first();

        

        if($categoryType->type == 'category' )
        {
            return back()
            ->with('error','You Select Category Type!');

        }else{

                $res = Product::create($data);
                if($res)
                {
                    return back()
                    ->with('success', $request->name.' Has Been Added!.');
                    
                    
                    
                }else{
                    return back()
                    ->with('error','Something Went Wrong!');
                }
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
        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'productList';

        $data['product'] = Product::where(['id'=>$id])->first();
        return view('admin.product.view-product',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['mainMenu'] = 'productManagement';
        $data['subMenu'] = 'productList';

        $data['product'] = Product::where(['id'=>$id])->first();
        $data['teachers'] = Admin_user::where(['role_id'=>7])->get();
        return view('admin.product.edit-product',$data);
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
        // dd($request->input());
        $admin_id = $request->session()->get('loggedIn')['id']; 
       
        $product = Product::where(['id'=>$id])->first();

        // dd($request->image);
        if(!empty($request->image))
        {
            $request->validate([
                'name'=>'required',
                'teacher_id'=>'required',
                'type'=>'required',
                'short_desc'=>'required',
                'description'=>'required',
                'features'=>'required',
                'slug'=>'required',
                'sort_order'=>'required',
                'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            if(File::exists(public_path('uploads/products/'.$product->image))){

                File::delete(public_path('uploads/products/'.$product->image));
    
            }


            $imageName = time().rand().'.'.$request->image->extension();    
            $request->image->move(public_path('uploads/products'), $imageName);

            $data = array(

                'admin_id'=>$admin_id,
                'teacher_id'=>$request->teacher_id,
                'name'=>$request->name,
                'type'=>$request->type,
                'short_desc'=>$request->short_desc,
                'description'=>$request->description,
                'video_url'=>$request->videoUrl,
                'features'=>$request->features,
                'image'=>$imageName,
                'slug'=>$request->slug,
                'sort_order'=>$request->sort_order,
                'status'=>$request->status,
                
            );
    
            $res = Product::where(['id'=>$id])->update($data);
            if($res)
            {
                return back()
                ->with('success', $request->name.' Has Been Added!.');
                
                
                
            }else{
                return back()
                ->with('error','Something Went Wrong!');
            }

        }

        if(empty($request->image))
        {
            // dd($request->input());
            $request->validate([
                'name'=>'required',
                'teacher_id'=>'required',
                'type'=>'required',
                'short_desc'=>'required',
                'description'=>'required',
                'features'=>'required',
                'slug'=>'required',
                'sort_order'=>'required',
                
            ]);


            $data = array(

                'admin_id'=>$admin_id,
                'teacher_id'=>$request->teacher_id,
                'name'=>$request->name,
                'type'=>$request->type,
                'short_desc'=>$request->short_desc,
                'description'=>$request->description,
                'video_url'=>$request->videoUrl,
                'features'=>$request->features,                
                'slug'=>$request->slug,
                'sort_order'=>$request->sort_order,
                'status'=>$request->status,
                
            );

            // dd($data);
    
            $res = Product::where(['id'=>$id])->update($data);
            if($res)
            {
                return back()
                ->with('success', $request->name.' Has Been Added!.');
                
                
                
            }else{
                return back()
                ->with('error','Something Went Wrong!');
            }

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
        $delete = Product::where(['id'=>$id])->first();
        
        if(File::exists(public_path('uploads/products/'.$delete->image))){

            File::delete(public_path('uploads/products/'.$delete->image));

        }
        Product::where(['id'=>$id])->delete();
         return back()->with('success','Post deleted successfully');
    }
}
